//package symbol_table;
//
//public class Row {
//
//    String type;
//    String value;
//
//    public String getType(){
//        return type;
//    }
//
//    public void setType(String type){
//        this.type = type;
//    }
//
//    public String getValue(){
//        return value;
//    }
//
//    public void setValue(String value){
//        this.value = value;
//    }
//
//}


package symbol_table;

public class Row {
    public String name;

    String type;
    String value;
    int line;
    int column;
    private Object additionalData;



    // Getters and Setters

    public String getType() { return type; }
    public void setType(String type) { this.type = type; }
    public String getValue() { return value; }
    public void setValue(String value) { this.value = value; }
    public int getLine() { return line; }
    public void setLine(int line) { this.line = line; }
    public int getColumn() { return column; }
    public void setColumn(int column) { this.column = column; }
    public Object getAdditionalData() {
        return additionalData;
    }

    public void setAdditionalData(Object additionalData) {
        this.additionalData = additionalData;
    }


}