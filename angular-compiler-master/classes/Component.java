package classes;

public class Component extends ComponentNode{

    private ComponentMetadata componentMetadata;
    private TypeScriptClass typeScriptClass;

    public ComponentMetadata getComponentMetadata() {
        return componentMetadata;
    }

    public void setComponentMetadata(ComponentMetadata componentMetadata) {
        this.componentMetadata = componentMetadata;
    }

    public TypeScriptClass getTypeScriptClass() {
        return typeScriptClass;
    }

    public void setTypeScriptClass(TypeScriptClass typeScriptClass) {
        this.typeScriptClass = typeScriptClass;
    }

    @Override
    public String toString() {
        return "\nComponent{" +
                "\ncomponentMetadata=" + componentMetadata +
                ", \ntypeScriptClass=" + typeScriptClass +
                "\n}";
    }
}
