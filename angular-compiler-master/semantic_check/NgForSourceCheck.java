package semantic_check;

import symbol_table.Row;
import symbol_table.SymbolTable;


import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.util.HashSet;
import java.util.List;
import java.util.Set;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class NgForSourceCheck implements SemanticCheck{
    private static final String OUTPUT_FILE = "semantic-errors.txt";

    @Override
    public void check(SymbolTable symbolTable, List<SemanticError> errors) {
        Set<String> componentVariables = new HashSet<>();

        for (Row row : symbolTable.getRows()) {
            if ("classProperty".equals(row.getType())) {
                String variableName = row.getValue();
                if (variableName != null && !variableName.isEmpty()) {
                    componentVariables.add(variableName);
                }
            }
        }

        for (Row row : symbolTable.getRows()) {
            if ("template".equals(row.getType())) {
                if (!(row.getAdditionalData() instanceof TemplateWithLines)) continue;

                TemplateWithLines template = (TemplateWithLines) row.getAdditionalData();
                String content = template.getContent();
                if (content == null) continue;

                Pattern pattern = Pattern.compile(
                        "\\*ngFor\\s*=\\s*[\"']\\s*let\\s+\\w+\\s+of\\s*([^\"']*)\\s*[\"']",
                        Pattern.CASE_INSENSITIVE
                );
                Matcher matcher = pattern.matcher(content);

                while (matcher.find()) {
                    String source = matcher.group(1).trim();
                    int offset = matcher.start(1);
                    int line = template.getLineForOffset(offset);
                    int column = template.getColumnForOffset(offset);

                    if (source.isEmpty()) {
                        addError(errors,
                                "Invalid *ngFor usage",
                                "*ngFor must have a data source (e.g., 'let item of items')",
                                line, column
                        );
                        continue;
                    }

                    String baseVar = source.split("[\\.\\[\\?]")[0];
                    if (!componentVariables.contains(baseVar)) {
                        addError(errors,
                                "Undefined ngFor source",
                                "The data source '" + baseVar + "' used in *ngFor is not defined in the component class",
                                line, column
                        );
                    }
                }
            }
        }
    }

    private void addError(List<SemanticError> errors, String message,
                          String details, int line, int column) {
        SemanticError error = new SemanticError(message, details, line, column, ErrorType.SEMANTIC);
        errors.add(error);
        appendErrorToFile(error);
    }

    private void appendErrorToFile(SemanticError error) {
        try (BufferedWriter writer = new BufferedWriter(new FileWriter(OUTPUT_FILE, true))) {
            writer.write("Error:\n");
            writer.write("├─ Type: " + error.getType() + "\n");
            writer.write("├─ Message: " + error.getMessage() + "\n");
            writer.write("├─ Details: " + error.getTitle() + "\n");
            writer.write("├─ Location: Line " + error.getLine() + ", Column " + error.getColumn() + "\n");
            writer.write("└─" + "-".repeat(50) + "\n\n");
        } catch (IOException e) {
            System.err.println("Failed to write error to file: " + e.getMessage());
        }
    }


}
