package code_generation;

public class GenericView extends BaseComponentView{
    private final String selector;
    private final String className;
    private final String template;
    private final String styles;
    private final String logic;

    public GenericView(String selector, String className, String template, String styles, String logic) {
        this.selector = selector;
        this.className = className;
        this.template = template;
        this.styles = styles;
        this.logic = logic;
    }

    @Override
    protected String getSelector() {
        return selector;
    }

    @Override
    protected String getClassName() {
        return className;
    }

    @Override
    protected String generateTemplate() {
        return template;
    }

    @Override
    protected String generateStyles() {
        return styles;
    }

    @Override
    protected String generateLogic() {
        return logic;
    }

    @Override
    protected String generateImports() {
        return "import { Component } from '@angular/core';";
    }
}
