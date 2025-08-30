package semantic_check;

import symbol_table.Row;
import symbol_table.SymbolTable;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class ComponentRequirementsCheck implements SemanticCheck{
    private static final String OUTPUT_FILE = "semantic-errors.txt";

    @Override
    public void check(SymbolTable symbolTable, List<SemanticError> errors) {
        boolean hasComponent = false;
        boolean hasSelector = false;
        boolean hasTemplate = false;
        boolean hasInvalidBinding = false;

        Row componentRow = null;
        List<Row> invalidBindings = new ArrayList<>();

        for (Row row : symbolTable.getRows()) {
            switch (row.getType()) {
                case "component":
                    hasComponent = true;
                    componentRow = row;
                    break;
                case "selector":
                    hasSelector = true;
                    break;
                case "template":
                    hasTemplate = true;
                    break;
                case "attributeBinding":
                    if (row.getValue() != null && row.getValue().matches(".*\\{\\{.+\\}\\}.*")) {
                        hasInvalidBinding = true;
                        invalidBindings.add(row);
                    }
                    break;
            }
        }

        if (hasComponent && componentRow != null) {
            if (!hasSelector) {
                SemanticError error = new SemanticError(
                        "Missing required 'selector' in component",
                        "Component must have a selector defined",
                        componentRow.getLine(),
                        componentRow.getColumn(),
                        ErrorType.SEMANTIC
                );
                errors.add(error);
                appendErrorToFile(error);
            }

            if (!hasTemplate) {
                SemanticError error = new SemanticError(
                        "Missing required 'template' in component",
                        "Component must have a template defined",
                        componentRow.getLine(),
                        componentRow.getColumn(),
                        ErrorType.SEMANTIC
                );
                errors.add(error);
                appendErrorToFile(error);
            }
        }

        for (Row row : invalidBindings) {
            SemanticError error = new SemanticError(
                    "Invalid template binding: " + row.getValue(),
                    "Template contains unbound properties or invalid expressions",
                    row.getLine(),
                    row.getColumn(),
                    ErrorType.SEMANTIC
            );
            errors.add(error);
            appendErrorToFile(error);
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
