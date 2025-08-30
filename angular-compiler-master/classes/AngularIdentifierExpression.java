package classes;

public class AngularIdentifierExpression extends Expression{

    private String identifier;

    public String getIdentifier() {
        return identifier;
    }

    public void setIdentifier(String identifier) {
        this.identifier = identifier;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nAngularIdentifierExpression{");
        sb.append("\nidentifier='").append(identifier).append('\'');
        sb.append("\n}");
        return sb.toString();
    }
}
