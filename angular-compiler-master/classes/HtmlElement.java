package classes;

public class HtmlElement extends HtmlNode{

    private String tagName;
    private HtmlContent[] htmlContents;

    public String getTagName() {
        return tagName;
    }

    public void setTagName(String tagName) {
        this.tagName = tagName;
    }

    public HtmlContent[] getHtmlContents() {
        return htmlContents;
    }

    public void setHtmlContents(HtmlContent[] htmlContents) {
        this.htmlContents = htmlContents;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nHtmlElement{");
        sb.append("\ntagName='" + tagName + '\'' +
                ", htmlContents=");
        if (htmlContents != null) {
            for (HtmlContent content : htmlContents) {
                sb.append("\n").append(content);
            }
        }
        sb.append("\n}");
        return sb.toString();
    }
}
