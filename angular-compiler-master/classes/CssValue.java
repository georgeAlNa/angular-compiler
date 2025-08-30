package classes;

public class CssValue extends CssNode{

    private String percentageValue;
    private String functionValue;
    private String colorValue;
    private String stringValue;
    private String numberValue;
    private String alphabetOnlyValue;

    public String getPercentageValue() {
        return percentageValue;
    }

    public void setPercentageValue(String percentageValue) {
        this.percentageValue = percentageValue;
    }

    public String getFunctionValue() {
        return functionValue;
    }

    public void setFunctionValue(String functionValue) {
        this.functionValue = functionValue;
    }

    public String getColorValue() {
        return colorValue;
    }

    public void setColorValue(String colorValue) {
        this.colorValue = colorValue;
    }

    public String getStringValue() {
        return stringValue;
    }

    public void setStringValue(String stringValue) {
        this.stringValue = stringValue;
    }

    public String getNumberValue() {
        return numberValue;
    }

    public void setNumberValue(String numberValue) {
        this.numberValue = numberValue;
    }

    public String getAlphabetOnlyValue() {
        return alphabetOnlyValue;
    }

    public void setAlphabetOnlyValue(String alphabetOnlyValue) {
        this.alphabetOnlyValue = alphabetOnlyValue;
    }

    @Override
    public String toString() {
        return "\nCssValue{" +
                "\npercentageValue='" + percentageValue + '\'' +
                ", \nfunctionValue='" + functionValue + '\'' +
                ", \ncolorValue='" + colorValue + '\'' +
                ", \nstringValue='" + stringValue + '\'' +
                ", \nnumberValue='" + numberValue + '\'' +
                ", \nalphabetOnlyValue='" + alphabetOnlyValue + '\'' +
                "\n}";
    }
}

