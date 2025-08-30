package classes;

public class AngularTemplateExpression extends Expression{

    private String template;

    public String getTemplate() {
        return template;
    }

    public void setTemplate(String template) {
        this.template = template;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nAngularTemplateExpression{");
        sb.append("\ntemplate='").append(template).append('\'');
        sb.append("\n}");
        return sb.toString();
    }
}
