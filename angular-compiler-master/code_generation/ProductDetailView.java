package code_generation;

public class ProductDetailView extends BaseComponentView{
    private final String template;
    private final String styles;
    private final String logic;

    public ProductDetailView(String template, String styles, String logic) {
        this.template = template;
        this.styles = styles;
        this.logic = logic;
    }

    @Override
    protected String getSelector() {
        return "app-detail";
    }

    @Override
    protected String getClassName() {
        return "ProductDetail";
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
        return """
        import { Component, OnInit } from '@angular/core';
        import { ActivatedRoute, Router } from '@angular/router';
        """;
    }
}
