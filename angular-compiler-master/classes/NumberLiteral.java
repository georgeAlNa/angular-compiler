package classes;

public class NumberLiteral extends Expression{

    private double value;

//    public double getValue() {
//        return value;
//    }

    public void setValue(double value) {
        this.value = value;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nNumberLiteral{");
        sb.append("\nvalue=").append(value);
        sb.append("\n}");
        return sb.toString();
    }
}
