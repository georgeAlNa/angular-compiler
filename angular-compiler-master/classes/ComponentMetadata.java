package classes;

import java.util.ArrayList;
import java.util.List;

public class ComponentMetadata extends ComponentNode{

    private List<MetadataEntry> metadataEntries = new ArrayList<>();

    public List<MetadataEntry> getMetadataEntries() {
        return metadataEntries;
    }

    public void setMetadataEntries(List<MetadataEntry> metadataEntries) {
        this.metadataEntries = metadataEntries;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nComponentMetadata{");
        if (metadataEntries != null) {
            for (MetadataEntry entry : metadataEntries) {
                sb.append("\n").append(entry);
            }
        }
        sb.append("\n}");
        return sb.toString();
    }
}
