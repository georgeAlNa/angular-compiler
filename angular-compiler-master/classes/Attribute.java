package classes;

public class Attribute {

    private HtmlAttributeBasic basicAttribute;
    private HtmlAttributeClass classAttribute;
    private HtmlAttributeStructural structuralAttribute;
    private HtmlAttributeBinding bindingAttribute;
    private HtmlAttributeEventBinding eventBindingAttribute;

    private String name;
    private String value;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getValue() {
        return value;
    }

    public void setValue(String value) {
        this.value = value;
    }

    public HtmlAttributeBasic getBasicAttribute() {
        return basicAttribute;
    }

    public void setBasicAttribute(HtmlAttributeBasic basicAttribute) {
        this.basicAttribute = basicAttribute;
    }

    public HtmlAttributeClass getClassAttribute() {
        return classAttribute;
    }

    public void setClassAttribute(HtmlAttributeClass classAttribute) {
        this.classAttribute = classAttribute;
    }

    public HtmlAttributeStructural getStructuralAttribute() {
        return structuralAttribute;
    }

    public void setStructuralAttribute(HtmlAttributeStructural structuralAttribute) {
        this.structuralAttribute = structuralAttribute;
    }

    public HtmlAttributeBinding getBindingAttribute() {
        return bindingAttribute;
    }

    public void setBindingAttribute(HtmlAttributeBinding bindingAttribute) {
        this.bindingAttribute = bindingAttribute;
    }

    public HtmlAttributeEventBinding getEventBindingAttribute() {
        return eventBindingAttribute;
    }

    public void setEventBindingAttribute(HtmlAttributeEventBinding eventBindingAttribute) {
        this.eventBindingAttribute = eventBindingAttribute;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder("\nAttribute{");
        if (basicAttribute != null) {
            sb.append("\nbasicAttribute=").append(basicAttribute);
        }
        if (classAttribute != null) {
            sb.append("\nclassAttribute=").append(classAttribute);
        }
        if (structuralAttribute != null) {
            sb.append("\nstructuralAttribute=").append(structuralAttribute);
        }
        if (bindingAttribute != null) {
            sb.append("\nbindingAttribute=").append(bindingAttribute);
        }
        if (eventBindingAttribute != null) {
            sb.append("\neventBindingAttribute=").append(eventBindingAttribute);
        }
        sb.append("\n}");
        return sb.toString();
    }
}

