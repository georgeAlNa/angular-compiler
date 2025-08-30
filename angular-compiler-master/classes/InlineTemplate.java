package classes;

public class InlineTemplate implements ASTNode{

    private HtmlDocument htmlDocument;

    public InlineTemplate(String text) {

    }

    public InlineTemplate() {

    }

    public HtmlDocument getHtmlDocument() {
        return htmlDocument;
    }

    public void setHtmlDocument(HtmlDocument htmlDocument) {
        this.htmlDocument = htmlDocument;
    }

    @Override
    public String toString() {
        return "\nInlineTemplate{" +
                "\nhtmlDocument=" + htmlDocument +
                "\n}";
    }
}
