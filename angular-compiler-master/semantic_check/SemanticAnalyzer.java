package semantic_check;

import symbol_table.Row;
import symbol_table.SymbolTable;

import java.util.ArrayList;
import java.util.List;

public class SemanticAnalyzer {
    private SymbolTable symbolTable;
    private List<SemanticError> errors;
    private List<SemanticCheck> checks;



    // الجداول المخصصة
//    public ComponentRequirementsSymbolTable compReqTable;
//    public NgForSourceSymbolTable ngForTable;
//    public TemplateVariablesSymbolTable templateVarTable;
//    public UnsafePropertyAccessSymbolTable unsafeAccessTable;


    public SemanticAnalyzer(SymbolTable symbolTable) {
        this.symbolTable = symbolTable;
        this.errors = new ArrayList<>();
        this.checks = new ArrayList<>();

        // تسجيل جميع الفحوصات الدلالية
        registerChecks();
    }

    public void registerChecks() {
        checks.add(new ComponentRequirementsCheck());
        checks.add(new TemplateVariablesCheck());
        checks.add(new NgForSourceCheck());
        checks.add(new UnsafePropertyAccessCheck());
    }

    public void analyze() {


        for (SemanticCheck check : checks) {
            check.check(symbolTable, errors);
        }


    }
    public void addError(String message, String details, int line, int column) {
        errors.add(new SemanticError(message, details, line, column, ErrorType.SEMANTIC));
    }

    public List<SemanticError> getErrors() {
        return errors;
    }
    public void printErrors() {
        if (!errors.isEmpty()) {
            System.out.println("\n=== Semantic Errors (" + errors.size() + ") ===");

            for (int i = 0; i < errors.size(); i++) {
                SemanticError error = errors.get(i);
                System.out.println("\nError #" + (i + 1) + ":");
                System.out.println("├─ Type: " +error.getType());
                System.out.println("├─ Message: " + error.getMessage());
                System.out.println("├─ Details: " + error.getTitle());
                System.out.println("├─ Location: Line " + error.getLine() + ", Column " + error.getColumn());

                // إذا كان الخطأ متعلقًا بالقالب، نعرض جزء من الكود مع تحديد الموقع
                if (isTemplateError(error)) {
                    printTemplateErrorContext(error);
                }

                System.out.println("└─" + "-".repeat(50));
            }
        }
    }

    private boolean isTemplateError(SemanticError error) {
        return error.getMessage().toLowerCase().contains("template") ||
                error.getMessage().toLowerCase().contains("ngfor") ||
                error.getMessage().toLowerCase().contains("binding");
    }

    private void printTemplateErrorContext(SemanticError error) {
        // البحث عن سطر القالب الذي يحتوي على الخطأ
        for (Row row : symbolTable.getRows()) {
            if (row.getType().equals("template")) {
                if (row.getLine() <= row.getLine() &&
                        row.getLine() <= row.getLine() + countLines(row.getValue())) {

                    System.out.println("├─ Template Context:");
                    String[] templateLines = row.getValue().split("\n");
                    int errorLineInTemplate = row.getLine() - row.getLine();

                    // عرض السطر الذي به الخطأ مع الأسطر المجاورة
                    int start = Math.max(0, errorLineInTemplate - 2);
                    int end = Math.min(templateLines.length - 1, errorLineInTemplate + 2);

                    for (int i = start; i <= end; i++) {
                        if (i == errorLineInTemplate) {
                            System.out.println("│  >> " + templateLines[i].trim());
                            // إظهار مؤشر إلى مكان الخطأ في السطر
                            String pointer = " ".repeat(row.getColumn() + 4) + "^";
                            System.out.println("│  " + pointer);
                        } else {
                            System.out.println("│     " + templateLines[i].trim());
                        }
                    }
                    break;
                }
            }
        }
    }
    private int countLines(String str) {
        if (str == null) return 0;
        return str.split("\n").length;
    }
}
