package classes;

public class Expression implements ASTNode{

    private String identifier;
    private String value;

    public Expression() {
    }

    public Expression(String identifier, String value) {
        this.identifier = identifier;
        this.value = value;
    }

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
        return "\nExpression{" +
                (identifier != null ? "\nidentifier='" + identifier + '\'' : "") +
                (value != null ? ", \nvalue='" + value + '\'' : "") +
                "\n}";
    }
}
