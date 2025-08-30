package classes;

import java.util.Arrays;

public class ArgumentList implements ASTNode{

    private Expression[] expressions;

    public Expression[] getExpressions() {
        return expressions;
    }

    public void setExpressions(Expression[] expressions) {
        this.expressions = expressions;
    }

    @Override
    public String toString() {
        return "\nArgumentList{" +
                "\nexpressions=" + Arrays.toString(expressions) +
                "\n}";
    }
}
