package classes;

import java.util.List;

public class TestBlock implements ASTNode{

    private List<AngularExpression> angularExpressions;

    public List<AngularExpression> getAngularExpressions() {
        return angularExpressions;
    }

    public void setAngularExpressions(List<AngularExpression> angularExpressions) {
        this.angularExpressions = angularExpressions;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nTestBlock{");
        sb.append("\nangularExpressions=");
        if (angularExpressions != null) {
            for (AngularExpression expr : angularExpressions) {
                sb.append("\n").append(expr);
            }
        }
        sb.append("\n}");
        return sb.toString();
    }
}
