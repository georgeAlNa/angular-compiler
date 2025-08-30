package classes;

public class HtmlDocument extends HtmlNode{

    private HtmlElement[] htmlElements;

    public HtmlElement[] getHtmlElements() {
        return htmlElements;
    }

    public void setHtmlElements(HtmlElement[] htmlElements) {
        this.htmlElements = htmlElements;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nHtmlDocument{");
        if (htmlElements != null) {
            for (HtmlElement element : htmlElements) {
                sb.append("\n").append(element);
            }
        }
        sb.append("\n}");
        return sb.toString();
    }
}
