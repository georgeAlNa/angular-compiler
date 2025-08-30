package classes;

import java.util.ArrayList;
import java.util.List;

public class CssContent extends CssNode{

    private List<CssRule> cssRules = new ArrayList<>();

    public List<CssRule> getCssRules() {
        return cssRules;
    }

    public void setCssRules(List<CssRule> cssRules) {
        this.cssRules = cssRules;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nCssContent{");
        if (cssRules != null) {
            for (CssRule rule : cssRules) {
                sb.append("\n").append(rule);
            }
        }
        sb.append("\n}");
        return sb.toString();
    }
}
