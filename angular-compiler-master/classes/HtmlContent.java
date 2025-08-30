package classes;

public class HtmlContent extends HtmlNode{

    private String textContent;
    private HtmlElement nestedElement;

    public String getTextContent() {
        return textContent;
    }

    public void setTextContent(String textContent) {
        this.textContent = textContent;
    }

    public HtmlElement getNestedElement() {
        return nestedElement;
    }

    public void setNestedElement(HtmlElement nestedElement) {
        this.nestedElement = nestedElement;
    }

    @Override
    public String toString() {
        return "\nHtmlContent{" +
                "\ntextContent='" + textContent + '\'' +
                ", \nnestedElement=" + nestedElement +
                "\n}";


    }
}
