package semantic_check;

public class SemanticError extends Error{
    private String title;
    private String message;
    private int line;
    private int column;
    private ErrorType type;


    public SemanticError (String title, String message, int line, int column, ErrorType type) {
        this.title = title;
        this.message = message;
        this.line = line;
        this.column = column;
        this.type = type;
    }

    @Override

    public String toString() {
        return String.format("[%s] %s: %s (Line: %d, Column: %d)",
                type, title, message, line, column);
    }


    public String getTitle() {
        return title;
    }

    @Override
    public String getMessage() {
        return message;
    }

    public int getLine() {
        return line;
    }

    public int getColumn() {
        return column;
    }

    public ErrorType getType() {
        return type;
    }
}
