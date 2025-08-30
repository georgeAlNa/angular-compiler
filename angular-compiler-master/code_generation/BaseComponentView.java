package code_generation;

public abstract class BaseComponentView implements View{
    protected abstract String getSelector();
    protected abstract String getClassName();

    protected abstract String generateTemplate();
    protected abstract String generateStyles();
    protected abstract String generateLogic();
    protected abstract String generateImports();

    protected String assembleComponent() {
        String template = generateTemplate().replace("\n", " ").trim();
        String styles = generateStyles().replace("\n", " ").trim();




        return String.format(
                """
                %s
                @Component({
                  selector: '%s',
                  template: `%s`,
                  styles: `%s`
                })
                export class %s {
                %s
                }
                """,
                generateImports(),
                getSelector(),
                template,
                styles.isEmpty() ? "" : styles,
                getClassName(),
                generateLogic()
        );
    }

    @Override
    public final GeneratedComponent generate() {
        String tsCode = assembleComponent();
        String htmlCode = generateTemplate();
        String cssCode = generateStyles();

//        return new GeneratedComponent(tsCode, htmlCode, cssCode);
        return new GeneratedComponent(tsCode, htmlCode, cssCode, getClassName());

    }



}
