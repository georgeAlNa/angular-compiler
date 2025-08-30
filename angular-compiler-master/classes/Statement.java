package classes;

public class Statement implements ASTNode{

    private String expression;
    private FunctionCall functionCall;

    public String getExpression() {
        return expression;
    }

    public void setExpression(String expression) {
        this.expression = expression;
    }

    public FunctionCall getFunctionCall() {
        return functionCall;
    }

    public void setFunctionCall(FunctionCall functionCall) {
        this.functionCall = functionCall;
    }

    @Override
    public String toString() {
        return "\nStatement{" +
                "\nexpression=" + expression +
                ", \nfunctionCall=" + functionCall +
                "\n}";
    }
}
