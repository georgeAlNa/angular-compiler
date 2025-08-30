//package code_generation;
//
//public class GeneratedComponent {
//    private final String ts;
//    private final String html;
//    private final String css;
//
//    public GeneratedComponent(String ts, String html, String css) {
//        this.ts = ts;
//        this.html = html;
//        this.css = css;
//    }
//
//    public String getTs() { return ts; }
//    public String getHtml() { return html; }
//    public String getCss() { return css; }
//}


package code_generation;

public class GeneratedComponent {
    private final String ts;
    private final String html;
    private final String css;
    private final String componentName;

    public GeneratedComponent(String ts, String html, String css, String componentName) {
        this.ts = ts;
        this.html = html;
        this.css = css;
        this.componentName = componentName;
    }

    public String getTs() { return ts; }
    public String getHtml() { return html; }
    public String getCss() { return css; }
    public String getComponentName() { return componentName; }
}