package classes;

public class HtmlAttributeValue extends HtmlNode{

    private String value;

    public String getValue() {
        return value;
    }

    public void setValue(String value) {
        this.value = value;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nHtmlAttributeValue{");
        sb.append("\nvalue='").append(value).append('\'');
        sb.append("\n}");
        return sb.toString();
    }
}
