package code_generation;

import classes.*;

public class ViewFactory {

    public static BaseComponentView createView(Component component) {
        ComponentMetadata metadata = component.getComponentMetadata();
        String selector = extractSelector(metadata);
        String template = extractTemplate(metadata);
        String styles = extractStyles(metadata);
        String logic = extractLogic(component);

        if ("app-root".equals(selector)) {
            return new AppView(template, styles, logic);
        } else if ("app-products".equals(selector)) {
            return new ProductsListView(template, styles, logic);
        } else if ("app-add".equals(selector)) {
            return new AddProductView(template, styles, logic);
        } else if ("app-detail".equals(selector)) {
            return new ProductDetailView(template, styles, logic);
        } else {
            return new GenericView(selector, "CustomComponent", template, styles, logic);
        }
    }

    private static String extractSelector(ComponentMetadata metadata) {
        return metadata.getMetadataEntries().stream()
                .filter(e -> e instanceof SelectorEntry)
                .map(e -> ((SelectorEntry) e).getSelector())
                .findFirst()
                .orElse("unknown");
    }

    private static String extractTemplate(ComponentMetadata metadata) {
        return metadata.getMetadataEntries().stream()
                .filter(e -> e instanceof TemplateEntry)
                .map(e -> {
                    TemplateEntry templateEntry = (TemplateEntry) e;
                    InlineTemplate inlineTemplate = templateEntry.getInlineTemplate();
                    if (inlineTemplate == null || inlineTemplate.getHtmlDocument() == null) {
                        return "null";
                    }
                    HtmlDocument htmlDoc = inlineTemplate.getHtmlDocument();
                    return htmlDoc.toString();
                })
                .findFirst()
                .orElse("");
    }

    private static String extractStyles(ComponentMetadata metadata) {
        return metadata.getMetadataEntries().stream()
                .filter(e -> e instanceof StylesEntry)
                .map(e -> {
                    StylesContent content = ((StylesEntry) e).getStylesContent();
                    return content != null ? content.getCssContents().toString() : "";
                })
                .findFirst()
                .orElse("");
    }

    private static String extractLogic(Component component) {
        // هنا نستخرج المنطق من TypeScriptClass
        StringBuilder logic = new StringBuilder();

        if (component.getTypeScriptClass() == null) return "";

        var classBody = component.getTypeScriptClass().getClassBody();
        if (classBody == null) return "";

        for (var member : classBody.getClassMembers()) {
            if (member.getPropertyDeclaration() != null) {
                var prop = member.getPropertyDeclaration();
                logic.append("  ")
                        .append(prop.getIdentifier())
                        .append(" = ")
                        .append(prop.getValue() != null ? prop.getValue() : "''")
                        .append(";\n");
            }
            if (member.getMethodDeclaration() != null) {
                var method = member.getMethodDeclaration();
                logic.append("  ")
                        .append(method.getMethodName())
                        .append("(")
                        .append(String.join(", ", method.getParameterList().getParameters()))
                        .append(") {\n");
                for (var stmt : method.getMethodBody().getStatements()) {
                    logic.append("    ").append(stmt.getExpression()).append("\n");
                }
                logic.append("  }\n\n");
            }
        }

        return logic.toString();
    }
}
