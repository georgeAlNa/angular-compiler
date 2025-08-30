package classes;

public class HtmlTagName extends HtmlNode{

    private String tagName;

    public String getTagName() {
        return tagName;
    }

    public void setTagName(String tagName) {
        this.tagName = tagName;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nHtmlTagName{");
        sb.append("\ntagName='").append(tagName).append('\'');
        sb.append("\n}");
        return sb.toString();
    }
}

