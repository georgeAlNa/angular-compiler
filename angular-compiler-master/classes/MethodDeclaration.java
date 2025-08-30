package classes;

public class MethodDeclaration extends Statement{
    private String methodName;
    private ParameterList parameterList;
    private MethodBody methodBody;

    public String getMethodName() {
        return methodName;
    }

    public void setMethodName(String methodName) {
        this.methodName = methodName;
    }

    public ParameterList getParameterList() {
        return parameterList;
    }

    public void setParameterList(ParameterList parameterList) {
        this.parameterList = parameterList;
    }

    public MethodBody getMethodBody() {
        return methodBody;
    }

    public void setMethodBody(MethodBody methodBody) {
        this.methodBody = methodBody;
    }

    @Override
    public String toString() {
        return "\nMethodDeclaration{" +
                "\nmethodName='" + methodName + '\'' +
                ", \nparameterList=" + parameterList +
                ", \nmethodBody=" + methodBody +
                "\n}";
    }
}
