package classes;

public class AngularExpression extends Expression{

    private AngularIdentifierExpression identifierExpression;
    private String stringExpression;
    private AngularTemplateExpression templateExpression;

    public AngularIdentifierExpression getIdentifierExpression() {
        return identifierExpression;
    }

    public void setIdentifierExpression(AngularIdentifierExpression identifierExpression) {
        this.identifierExpression = identifierExpression;
    }

    public String getStringExpression() {
        return stringExpression;
    }

    public void setStringExpression(String stringExpression) {this.stringExpression = stringExpression;
    }

    public AngularTemplateExpression getTemplateExpression() {
        return templateExpression;
    }

    public void setTemplateExpression(AngularTemplateExpression templateExpression) {
        this.templateExpression = templateExpression;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nAngularExpression{");
        if (identifierExpression != null) {
            sb.append("\nidentifierExpression=").append(identifierExpression);
        }
        if (stringExpression != null) {
            sb.append("\nstringExpression=").append(stringExpression);
        }
        if (templateExpression != null) {
            sb.append("\ntemplateExpression=").append(templateExpression);
        }
        sb.append("\n}");
        return sb.toString();
    }
}

