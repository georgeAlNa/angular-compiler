package classes;

public class FunctionCall extends Expression{

    private String functionName;
    private ArgumentList argumentList;

    public String getFunctionName() {
        return functionName;
    }

    public void setFunctionName(String functionName) {
        this.functionName = functionName;
    }

    public ArgumentList getArgumentList() {
        return argumentList;
    }

    public void setArgumentList(ArgumentList argumentList) {
        this.argumentList = argumentList;
    }

    @Override
    public String toString() {
        return "\nFunctionCall{" +
                "\nfunctionName='" + functionName + '\'' +
                ",\nargumentList=" + argumentList +
                "\n}";
    }
}
