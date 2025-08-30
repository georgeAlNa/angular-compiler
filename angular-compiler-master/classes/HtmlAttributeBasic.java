package classes;

public class HtmlAttributeBasic extends HtmlNode{

    private String attributeName;
    private String attributeValue;

    public String getAttributeName() {
        return attributeName;
    }

    public void setAttributeName(String attributeName) {
        this.attributeName = attributeName;
    }

    public String getAttributeValue() {
        return attributeValue;
    }

    public void setAttributeValue(String attributeValue) {
        this.attributeValue = attributeValue;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nHtmlAttributeBasic{");
        sb.append("\nattributeName='").append(attributeName).append('\'');
        sb.append("\nattributeValue='").append(attributeValue).append('\'');
        sb.append("\n}");
        return sb.toString();
    }
}
