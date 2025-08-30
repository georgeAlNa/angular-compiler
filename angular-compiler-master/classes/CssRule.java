package classes;

import java.util.ArrayList;
import java.util.List;

public class CssRule extends CssNode{

    private String selector;
    private List<CssDeclaration> declarations = new ArrayList<>();

    public String getSelector() {
        return selector;
    }

    public void setSelector(String selector) {
        this.selector = selector;
    }

    public List<CssDeclaration> getDeclarations() {
        return declarations;
    }

    public void setDeclarations(List<CssDeclaration> declarations) {
        this.declarations = declarations;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nCssRule{");
        sb.append("\nselector='" + selector + '\'' +
                ", declarations=");
        if (declarations != null) {
            for (CssDeclaration declaration : declarations) {
                sb.append("\n").append(declaration);
            }
        }
        sb.append("\n}");
        return sb.toString();
    }
}
