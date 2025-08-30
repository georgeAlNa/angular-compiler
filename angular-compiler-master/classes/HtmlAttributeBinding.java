package classes;

public class HtmlAttributeBinding extends HtmlNode{

    private String attributeValue;

    public String getAttributeValue() {
        return attributeValue;
    }

    public void setAttributeValue(String attributeValue) {
        this.attributeValue = attributeValue;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nHtmlAttributeBinding{");
        sb.append("\nattributeValue='").append(attributeValue).append('\'');
        sb.append("\n}");
        return sb.toString();
    }
}
