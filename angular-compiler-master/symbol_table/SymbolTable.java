
//package symbol_table;
//import java.util.ArrayList;
//import java.util.List;
//
//public class SymbolTable {
//    List<Row> rows = new ArrayList<>();
//
//    public List<Row> getRows(){
//        return rows;
//    }
//
//    public void setRows(List<Row> rows){
//        this.rows = rows;
//    }
//
//    public void print(){
//        for(int i = 0 ; i < rows.size() ; i++){
//            if (rows.get(i) != null){
//                System.out.println(rows.get(i).getType() + "\t\t\t\t" + rows.get(i).getValue());
//            }
//        }
//    }
//}

package symbol_table;

import java.util.ArrayList;
import java.util.List;

public class SymbolTable {
    List<Row> rows = new ArrayList<>();

    public List<Row> getRows() { return rows; }
    public void setRows(List<Row> rows) { this.rows = rows; }

    public void print() {
        System.out.println("\n════════════════════ Symbol Table ════════════════════");
        System.out.printf("%-15s %-25s %-12s%n", "Type", "Value", "Location");
        System.out.println("───────────────────────────────────────────────────────");

        for (Row row : rows) {
            if (row != null) {
                String type = row.getType();
                String value = formatValue(row);
                String location = row.getLine() + ":" + row.getColumn();

                System.out.printf("%-15s %-25s %-12s%n",
                        type,
                        value.length() > 25 ? value.substring(0, 22) + "..." : value,
                        location);

                if ("template".equals(type) && row.getValue() != null) {
                    printTemplateContent(row.getValue());
                }
            }
        }
        System.out.println("═══════════════════════════════════════════════════════");
    }

    private String formatValue(Row row) {
        String value = row.getValue();
        if (value == null) return "null";

        if ("template".equals(row.getType())) {
            return "[Template]";
        }
        return value.replace("\n", "\\n");
    }

    private void printTemplateContent(String template) {
        System.out.println("\nTemplate Content:");
        System.out.println("┌─────────────────────────────────────────────────────");

        String[] lines = template.split("\n");
        for (String line : lines) {
            System.out.println("│ " + line);
        }

        System.out.println("└─────────────────────────────────────────────────────");
    }
}
