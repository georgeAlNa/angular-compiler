package classes;

public class HtmlStartTag extends HtmlNode{

    private String tagName;
    private Attribute[] attributes;

    public String getTagName() {
        return tagName;
    }

    public void setTagName(String tagName) {
        this.tagName = tagName;
    }

    public Attribute[] getAttributes() {
        return attributes;
    }

    public void setAttributes(Attribute[] attributes) {
        this.attributes = attributes;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nHtmlStartTag{");
        sb.append("\ntagName='").append(tagName).append('\'');
        if (attributes != null) {
            sb.append(", \nattributes=");
            for (Attribute attribute : attributes) {
                sb.append("\n").append(attribute);
            }
        }
        sb.append("\n}");
        return sb.toString();
    }
}
