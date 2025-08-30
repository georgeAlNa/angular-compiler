package code_generation;

public class AddProductView extends BaseComponentView{
    private final String template;
    private final String styles;
    private final String logic;

    public AddProductView(String template, String styles, String logic) {
        this.template = template;
        this.styles = styles;
        this.logic = logic;
    }

    @Override
    protected String getSelector() {
        return "app-add";
    }

    @Override
    protected String getClassName() {
        return "AddProduct";
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
