package classes;

import java.util.ArrayList;
import java.util.List;

public class StylesContent extends CssNode{

    private List<CssContent> cssContents = new ArrayList<>();
    private String rawText = "";

    public StylesContent(String text) {
        this.rawText = text != null ? text : "";

        if (text == null || text.trim().isEmpty()) {
            return;
        }

        // Remove surrounding backticks if present
        String cleaned = text.trim();
        if (cleaned.startsWith("`")) {
            cleaned = cleaned.substring(1);
        }
        if (cleaned.endsWith("`")) {
            cleaned = cleaned.substring(0, cleaned.length() - 1);
        }

        CssContent cssContent = new CssContent();

        // Split the text into rule blocks using '}' as a delimiter
        String[] ruleBlocks = cleaned.split("}");
        for (String block : ruleBlocks) {
            block = block.trim();
            if (block.isEmpty()) {
                continue;
            }

            String[] parts = block.split("\\{", 2);
            if (parts.length < 2) {
                continue; // not a valid rule
            }

            CssRule rule = new CssRule();
            rule.setSelector(parts[0].trim());

            String declarationsText = parts[1].trim();
            String[] declarations = declarationsText.split(";");
            for (String decl : declarations) {
                decl = decl.trim();
                if (decl.isEmpty()) {
                    continue;
                }
                String[] kv = decl.split(":", 2);
                CssDeclaration cssDeclaration = new CssDeclaration();
                cssDeclaration.setProperty(kv[0].trim());
                cssDeclaration.setValue(kv.length > 1 ? kv[1].trim() : "");
                rule.getDeclarations().add(cssDeclaration);
            }

            cssContent.getCssRules().add(rule);
        }

        if (!cssContent.getCssRules().isEmpty()) {
            cssContents.add(cssContent);
        }
    }

    public StylesContent() {
    }



    public List<CssContent> getCssContents() {
        return cssContents;
    }

    public void setCssContents(List<CssContent> cssContents) {
        this.cssContents = cssContents;
    }

    public String getRawText() {
        return rawText;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nStylesContent{");
        if (cssContents != null) {
            for (CssContent content : cssContents) {
                sb.append("\n").append(content);
            }
        }
        sb.append("\n}");
        return sb.toString();
    }
}
