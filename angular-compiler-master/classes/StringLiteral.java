package classes;

public class StringLiteral extends Expression{

    private String value;

    public String getValue() {
        return value;
    }

    public void setValue(String value) {
        this.value = value;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nStringLiteral{");
        sb.append("\nvalue='").append(value).append('\'');
        sb.append("\n}");
        return sb.toString();
    }
}
