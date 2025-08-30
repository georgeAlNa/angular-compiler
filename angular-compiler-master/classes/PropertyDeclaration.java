package classes;

public class PropertyDeclaration extends Statement{
    private String identifier;
    private String value;

    public String getIdentifier() {
        return identifier;
    }

    public void setIdentifier(String identifier) {
        this.identifier = identifier;
    }

    public String getValue() {
        return value;
    }

    public void setValue(String value) {
        this.value = value;
    }

    @Override
    public String toString() {
        return "\nPropertyDeclaration{" +
                "\nidentifier='" + identifier + '\'' +
                ", \nvalue='" + value + '\'' +
                "\n}";
    }

}
