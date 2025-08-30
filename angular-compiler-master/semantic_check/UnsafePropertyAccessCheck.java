package semantic_check;

import symbol_table.Row;
import symbol_table.SymbolTable;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.util.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class UnsafePropertyAccessCheck implements SemanticCheck{
    private static final String OUTPUT_FILE = "semantic-errors.txt";
    @Override
    public void check(SymbolTable symbolTable, List<SemanticError> errors) {
        Map<String, Boolean> classProperties = new HashMap<>();
        Set<String> nullCheckedProperties = new HashSet<>();



        for (Row row : symbolTable.getRows()) {
            if ("classProperty".equals(row.getType())) {
                String propertyName = row.getValue();
                System.out.println(propertyName);
                boolean isNullable = "selectedProduct".equals(propertyName);
                classProperties.put(propertyName, isNullable);
            }
        }

        for (Row row : symbolTable.getRows()) {
            if (!"template".equals(row.getType())) continue;

            String template = row.getValue();
            if (template == null) continue;

            Pattern ngIfPattern = Pattern.compile("\\*ngIf=\"([^\"]*)\"");
            Matcher ngIfMatcher = ngIfPattern.matcher(template);

            while (ngIfMatcher.find()) {
                String condition = ngIfMatcher.group(1);
                if (classProperties.containsKey(condition)) {
                    nullCheckedProperties.add(condition);
                }
            }

            Pattern unsafePattern = Pattern.compile("(?<!\\?)\\b(\\w+)\\.(\\w+)\\b");
            Matcher unsafeMatcher = unsafePattern.matcher(template);

            while (unsafeMatcher.find()) {
                String objectName = unsafeMatcher.group(1);
                String propertyName = unsafeMatcher.group(2);

                if (classProperties.containsKey(objectName) &&
                        classProperties.get(objectName) &&
                        !nullCheckedProperties.contains(objectName)) {

                    int line = row.getLine();
                    int column = row.getColumn() + unsafeMatcher.start(1);

                    String beforeMatch = template.substring(0, unsafeMatcher.start());
                    String[] linesBefore = beforeMatch.split("\n");
                    if (linesBefore.length > 1) {
                        line += linesBefore.length - 1;
                        column = unsafeMatcher.start() - beforeMatch.lastIndexOf('\n') - 1;
                    }

                    errors.add(new SemanticError(
                            "Unsafe access to possibly null object",
                            "Accessing property '" + propertyName + "' of '" + objectName +
                                    "' without null check (use ?. or *ngIf)",
                            line,
                            column,
                            ErrorType.SEMANTIC
                    ));

                    for ( SemanticError err: errors
                    ) {
                        appendErrorToFile(err);
                    }
                }
            }
        }
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
