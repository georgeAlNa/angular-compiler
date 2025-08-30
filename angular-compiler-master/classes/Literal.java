package classes;

public class Literal implements ASTNode{

    private NullLiteral nullLiteral;
    private StringLiteral stringLiteral;
    private NumberLiteral numberLiteral;

    public NullLiteral getNullLiteral() {
        return nullLiteral;
    }

    public void setNullLiteral(NullLiteral nullLiteral) {
        this.nullLiteral = nullLiteral;
    }

    public StringLiteral getStringLiteral() {
        return stringLiteral;
    }

    public void setStringLiteral(StringLiteral stringLiteral) {
        this.stringLiteral = stringLiteral;
    }

    public NumberLiteral getNumberLiteral() {
        return numberLiteral;
    }

    public void setNumberLiteral(NumberLiteral numberLiteral) {
        this.numberLiteral = numberLiteral;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nLiteral{");
        if (nullLiteral != null) {
            sb.append("\nnullLiteral=").append(nullLiteral);
        }
        if (stringLiteral != null) {
            sb.append("\nstringLiteral=").append(stringLiteral);
        }
        if (numberLiteral != null) {
            sb.append("\nnumberLiteral=").append(numberLiteral);
        }
        sb.append("\n}");
        return sb.toString();
    }
}

