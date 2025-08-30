package classes;

public class TemplateEntry implements MetadataEntry {
    private InlineTemplate inlineTemplate;

    public TemplateEntry(InlineTemplate inlineTemplate) {
        this.inlineTemplate = inlineTemplate;
    }

    public InlineTemplate getInlineTemplate() {
        return inlineTemplate;
    }

    public void setInlineTemplate(InlineTemplate inlineTemplate) {
        this.inlineTemplate = inlineTemplate;
    }

    @Override
    public String toString() {
        return "TemplateEntry{inlineTemplate=" + inlineTemplate + "}";
    }
}
