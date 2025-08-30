package classes;

public class StylesEntry implements MetadataEntry {
    private StylesContent stylesContent;

    public StylesEntry(StylesContent stylesContent) {
        this.stylesContent = stylesContent;
    }

    public StylesContent getStylesContent() {
        return stylesContent;
    }

    public void setStylesContent(StylesContent stylesContent) {
        this.stylesContent = stylesContent;
    }

    @Override
    public String toString() {
        return "StylesEntry{stylesContent=" + stylesContent + "}";
    }
}
