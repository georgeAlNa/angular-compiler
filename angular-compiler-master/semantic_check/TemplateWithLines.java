package semantic_check;

import java.util.ArrayList;
import java.util.List;

public class TemplateWithLines {
    private String content;
    private int startLine;
    private List<Integer> lineOffsets;

    public TemplateWithLines(String content, int startLine) {
        this.content = content;
        this.startLine = startLine;
        this.lineOffsets = calculateLineOffsets(content);
    }

    private List<Integer> calculateLineOffsets(String content) {
        List<Integer> offsets = new ArrayList<>();
        offsets.add(0);
        int pos = 0;
        while (pos < content.length()) {
            pos = content.indexOf('\n', pos);
            if (pos == -1) break;
            pos++;
            offsets.add(pos);
        }
        return offsets;
    }

    public int getLineForOffset(int offset) {
        for (int i = 0; i < lineOffsets.size(); i++) {
            if (i == lineOffsets.size() - 1 || offset < lineOffsets.get(i + 1)) {
                return startLine + i;
            }
        }
        return startLine + lineOffsets.size() - 1;
    }

    public int getColumnForOffset(int offset) {
        int line = 0;
        for (int i = 0; i < lineOffsets.size(); i++) {
            if (i == lineOffsets.size() - 1 || offset < lineOffsets.get(i + 1)) {
                line = i;
                break;
            }
        }
        return offset - lineOffsets.get(line);
    }

    public String getContent() {
        return content;
    }

    public int getStartLine() {
        return startLine;
    }
}
