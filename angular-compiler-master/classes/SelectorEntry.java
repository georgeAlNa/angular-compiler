package classes;

public class SelectorEntry implements MetadataEntry {
    private String selector;

    public SelectorEntry(String selector) {
        this.selector = selector;
    }

    public String getSelector() {
        return selector;
    }

    public void setSelector(String selector) {
        this.selector = selector;
    }

    @Override
    public String toString() {
        return "SelectorEntry{selector='" + selector + "'}";
    }
}
