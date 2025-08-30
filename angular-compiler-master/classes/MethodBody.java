package classes;

public class MethodBody {

    private Statement[] statements;

    public Statement[] getStatements() {
        return statements;
    }

    public void setStatements(Statement[] statements) {
        this.statements = statements;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nMethodBody{");
        if (statements != null) {
            for (Statement statement : statements) {
                sb.append("\n").append(statement);
            }
        }
        sb.append("\n}");
        return sb.toString();
    }
}
