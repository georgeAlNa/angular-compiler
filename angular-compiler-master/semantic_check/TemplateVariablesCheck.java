package semantic_check;

import symbol_table.Row;
import symbol_table.SymbolTable;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class TemplateVariablesCheck implements SemanticCheck{
    private static final String OUTPUT_FILE = "semantic-errors.txt";

    @Override
    public void check(SymbolTable symbolTable, List<SemanticError> errors) {
        Set<String> componentVariables = new HashSet<>();
        Set<String> componentMethods = new HashSet<>();

        for (Row row : symbolTable.getRows()) {
            if ("classProperty".equals(row.getType()) || "importedVar".equals(row.getType())) {
                componentVariables.add(row.getValue());
            } else if ("methodDeclaration".equals(row.getType())) {
                componentMethods.add(row.getValue());
            }
        }

        for (Row row : symbolTable.getRows()) {
            if ("template".equals(row.getType())) {
                checkTemplateErrors(row, componentVariables, componentMethods, errors);
            }
        }
    }

    private void checkTemplateErrors(Row templateRow, Set<String> componentVariables,
                                     Set<String> componentMethods, List<SemanticError> errors) {
        if (!(templateRow.getAdditionalData() instanceof TemplateWithLines)) return;

        TemplateWithLines template = (TemplateWithLines) templateRow.getAdditionalData();
        String content = template.getContent();
        Set<String> allVariables = new HashSet<>(componentVariables);

        Matcher ngForMatcher = Pattern.compile(
                "\\*ngFor\\s*=\\s*[\"']\\s*let\\s+(\\w+)\\s+of\\s*([^\"']+)\\s*[\"']",
                Pattern.CASE_INSENSITIVE
        ).matcher(content);

        while (ngForMatcher.find()) {
            String localVar = ngForMatcher.group(1).trim();
            String source = ngForMatcher.group(2).trim();
            allVariables.add(localVar);

            int offset = ngForMatcher.start(2);
            int line = template.getLineForOffset(offset);
            int column = template.getColumnForOffset(offset);

            if (source.isEmpty()) continue;

            String baseVar = source.split("[\\.\\[\\?]")[0];
            if (!componentVariables.contains(baseVar)) {
                addError(errors,
                        "Undefined ngFor source",
                        "The data source '" + baseVar + "' used in *ngFor is not defined in the component class",
                        line, column);
            }
        }

        Matcher varMatcher = Pattern.compile("\\{\\{(.*?)\\}\\}").matcher(content);
        while (varMatcher.find()) {
            String expression = varMatcher.group(1).trim();
            int offset = varMatcher.start(1);
            int line = template.getLineForOffset(offset);
            int column = template.getColumnForOffset(offset);
            checkExpression(expression, allVariables, componentMethods, line, column, errors);
        }

        Matcher methodMatcher = Pattern.compile("([a-zA-Z_$][\\w$]*)\\s*\\(").matcher(content);
        while (methodMatcher.find()) {
            String methodName = methodMatcher.group(1);
            if (!componentMethods.contains(methodName)) {
                int offset = methodMatcher.start(1);
                int line = template.getLineForOffset(offset);
                int column = template.getColumnForOffset(offset);

                addError(errors, "Undefined method call",
                        "Method '" + methodName + "' is not defined",
                        line, column);
            }
        }
    }

    private void checkExpression(String expression, Set<String> variables,
                                 Set<String> methods, int line, int column,
                                 List<SemanticError> errors) {
        if (expression.length() >= 2 && ((expression.startsWith("\"") && expression.endsWith("\""))
                || (expression.startsWith("'") && expression.endsWith("'")))) {
            return;
        }
        String[] parts = expression.split("\\.|\\?");
        if (parts.length > 0) {
            String identifier = parts[0].trim();
            if (!variables.contains(identifier) && !methods.contains(identifier)) {
                addError(errors,
                        "Undefined identifier in template",
                        "The identifier '" + expression + "' is not defined in the component class",
                        line, column);
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
        try (BufferedWriter writer = new BufferedWriter(new FileWriter("semantic-errors.txt", true))) {
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
