package classes;

public class HtmlAttributeStructural extends HtmlNode{

    private String attributeValue;

    public String getAttributeValue() {
        return attributeValue;
    }

    public void setAttributeValue(String attributeValue) {
        this.attributeValue = attributeValue;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nHtmlAttributeStructural{");
        sb.append("\nattributeValue='").append(attributeValue).append('\'');
        sb.append("\n}");
        return sb.toString();
    }
}

