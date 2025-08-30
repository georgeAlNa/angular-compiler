//package classes;
//
//import AngularGen.AngularParser;
//import AngularGen.AngularParserBaseVisitor;
//import org.antlr.v4.runtime.CharStream;
//import org.antlr.v4.runtime.Token;
//import org.antlr.v4.runtime.misc.Interval;
//import org.antlr.v4.runtime.tree.ParseTree;
//import org.antlr.v4.runtime.tree.TerminalNode;
//import semantic_check.*;
//import symbol_table.Row;
//import symbol_table.SymbolTable;
//
//import java.util.ArrayList;
//import java.util.List;
//
//public class BaseVisitor extends AngularParserBaseVisitor {
//
//    SymbolTable symbolTable = new SymbolTable();
//    private SemanticAnalyzer analyzer = new SemanticAnalyzer(symbolTable);
//
//
//    // الجداول المخصصة
//    private ComponentRequirementsCheck compReqSymbolTable = new ComponentRequirementsCheck();
//    private NgForSourceCheck ngForSymbolTable = new NgForSourceCheck();
//    private TemplateVariablesCheck templateVarSymbolTable = new TemplateVariablesCheck();
//    private UnsafePropertyAccessCheck unsafeAccessSymbolTable = new UnsafePropertyAccessCheck();
//
//    @Override
//    public Application visitApplicationRoot(AngularParser.ApplicationRootContext ctx) {
//        Application application = new Application();
//        for (int i = 0; i < ctx.component().size(); i++) {
//            if (ctx.component(i) != null) {
//                Component component = (Component) visit(ctx.component(i));
//                application.getComponents().add(component);
//            }
//        }
////        analyzer.analyzer();
//
////        analyzer.checkComponentRequirements();
////        analyzer.checkNgForWithoutSource();
////        analyzer.checkConditionalAccess();
////        List<Row> Error = new ArrayList<>();
////        TemplateVariablesSymbolTable.printRelatedSymbolTable(Error);
//        // تحويل SymbolTable العام إلى الجداول المخصصة
////        convertToCustomSymbolTables();
//
//
//        analyzer.printErrors();
//        this.symbolTable.print();
//        return application;
//    }
//
//
//
//    @Override
//    public Component visitComponentDefinition(AngularParser.ComponentDefinitionContext ctx) {
//        Component component = new Component();
//
//        Row row = new Row();
//        row.setType("component");
//        row.setValue("@Component"); // يمكنك وضع اسم حقيقي إذا توفر لاحقًا
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        if (ctx.componentMetadata() == null) {
//            analyzer.getErrors().add(new SemanticError(
//                    "Missing component metadata",
//                    "Component must have metadata",
//                    ctx.start.getLine(),
//                    ctx.start.getCharPositionInLine(),
//                    ErrorType.SEMANTIC
//            ));
//        }
//        // معالجة metadata
//        else {
//            ComponentMetadata metadata = (ComponentMetadata) visit(ctx.componentMetadata());
//            component.setComponentMetadata(metadata);
//        }
//
//        // معالجة TypeScript class
//        if (ctx.typeScriptClass() != null) {
//            TypeScriptClass tsClass = (TypeScriptClass) visit(ctx.typeScriptClass());
//            component.setTypeScriptClass(tsClass);
//        }
//
//        return component;
//    }
//
//    @Override
//    public ComponentMetadata visitComponentMetadataDefinition(AngularParser.ComponentMetadataDefinitionContext ctx) {
//        ComponentMetadata componentMetadata = new ComponentMetadata();
//
//        for (int i = 0; i < ctx.metadataEntry().size(); i++) {
//            ParseTree tree = ctx.metadataEntry(i);
//            MetadataEntry entry = (MetadataEntry) visit(tree);
//            componentMetadata.getMetadataEntries().add(entry);
//        }
//
//        return componentMetadata;
//    }
//
//
//    public MetadataEntry visitMetadataSelector(AngularParser.MetadataSelectorContext ctx) {
//        String selector =  ctx.attributeValue().getText();
//
//        if (selector == null || selector.isEmpty()) {
//            analyzer.getErrors().add(new SemanticError(
//                    "Missing Selector",
//                    "Component must have Selector",
//                    ctx.start.getLine(),
//                    ctx.start.getCharPositionInLine(),
//                    ErrorType.SEMANTIC
//            ));
//        }
//
//        Row row = new Row();
//        row.setType("selector");
//        row.setValue(selector);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return new SelectorEntry(selector);
//    }
//
//    @Override
//    public MetadataEntry visitMetadataTemplate(AngularParser.MetadataTemplateContext ctx) {
//        if (ctx.inlineTemplate() == null) {
//            analyzer.addError("Missing component template",
//                    "Component must have template",
//                    ctx.start.getLine(),
//                    ctx.start.getCharPositionInLine());
//            return null;
//        }
//
//        // الحصول على المحتوى مع الحفاظ على الأسطر الأصلية
//        String templateContent = getOriginalTemplateText(ctx.inlineTemplate());
//        int templateStartLine = ctx.inlineTemplate().start.getLine();
//
//        TemplateWithLines templateWithLines = new TemplateWithLines(templateContent, templateStartLine);
//
//        Row row = new Row();
//        row.setType("template");
//        row.setValue(templateContent);
//        row.setLine(templateStartLine);
//        row.setColumn(ctx.inlineTemplate().start.getCharPositionInLine());
//        row.setAdditionalData(templateWithLines);
//        symbolTable.getRows().add(row);
//
//
//
//        return new TemplateEntry(new InlineTemplate(templateContent));
//    }
//
//    private String getOriginalTemplateText(AngularParser.InlineTemplateContext ctx) {
//        Token startToken = ctx.getStart();
//        Token endToken = ctx.getStop();
//        CharStream input = startToken.getInputStream();
//        return input.getText(Interval.of(startToken.getStartIndex(), endToken.getStopIndex()));
//    }
//    @Override
//    public MetadataEntry visitMetadataStyles(AngularParser.MetadataStylesContext ctx) {
//        StylesContent styles = new StylesContent(ctx.stylesContent().getText());
//
//        Row row = new Row();
//        row.setType("styles");
//        row.setValue(styles.toString());
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return new StylesEntry(styles);
//    }
//
//    @Override
//    public StylesContent visitStylesContentBlock(AngularParser.StylesContentBlockContext ctx) {
//        StylesContent stylesContent = new StylesContent();
//
//        Row row = new Row();
//        row.setType("stylesContent");
//        row.setValue(stylesContent.toString());
//        symbolTable.getRows().add(row);
//
//        for (int i = 0; i < ctx.cssContent().size(); i++) {
//            if (ctx.cssContent(i) != null) {
//                CssContent cssContent = (CssContent) visit(ctx.cssContent(i));
//                stylesContent.getCssContents().add(cssContent);
//            }
//        }
//
//        return stylesContent;
//    }
//
//
//    @Override
//    public CssContent visitCssContentRules(AngularParser.CssContentRulesContext ctx) {
//        CssContent cssContent = new CssContent();
//
//        Row row = new Row();
//        row.setType("cssContent");
//        row.setValue(cssContent.toString());
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        for (int i = 0; i < ctx.cssRule().size(); i++) {
//            if (ctx.cssRule(i) != null) {
//                CssRule cssRule = (CssRule) visit(ctx.cssRule(i));
//                cssContent.getCssRules().add(cssRule);
//            }
//        }
//
//        return cssContent;
//    }
//
//
//    @Override
//    public CssRule visitCssRuleDefinition(AngularParser.CssRuleDefinitionContext ctx) {
//        CssRule cssRule = new CssRule();
//
//        if (ctx.CSS_SELECTOR() != null) {
//            cssRule.setSelector(ctx.CSS_SELECTOR().getText());
//        }
//
//        // ⬅️ تسجيل cssRule
//        Row row = new Row();
//        row.setType("cssRule");
//        row.setValue(cssRule.getSelector() != null ? cssRule.getSelector() : "anonymous rule");
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        for (int i = 0; i < ctx.cssDeclaration().size(); i++) {
//            if (ctx.cssDeclaration(i) != null) {
//                CssDeclaration declaration = (CssDeclaration) visit(ctx.cssDeclaration(i));
//                cssRule.getDeclarations().add(declaration);
//            }
//        }
//
//        return cssRule;
//    }
//
//
//
//    @Override
//    public CssDeclaration visitCssDeclarationEntry(AngularParser.CssDeclarationEntryContext ctx) {
//        CssDeclaration cssDeclaration = new CssDeclaration();
//
//        if (ctx.CSS_PROPERTY() != null) {
//            cssDeclaration.setProperty(ctx.CSS_PROPERTY().getText());
//        }
//
//        if (ctx.cssValue() != null) {
//            cssDeclaration.setValue(ctx.cssValue().getText());
//        }
//
//        // ⬅️ تسجيل cssDeclaration
//        Row row = new Row();
//        row.setType("cssDeclaration");
//        row.setValue(cssDeclaration.getProperty() + ": " + cssDeclaration.getValue());
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return cssDeclaration;
//    }
//
//
//
//    @Override
//    public CssValue visitCssValuePercentage(AngularParser.CssValuePercentageContext ctx) {
//        CssValue cssValue = new CssValue();
//
//        if (ctx.PERCENTAGE() != null) {
//            cssValue.setPercentageValue(ctx.PERCENTAGE().getText());
//
//            // ⬅️ تسجيل cssValue
//            Row row = new Row();
//            row.setType("cssValue");
//            row.setValue(cssValue.getPercentageValue());
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return cssValue;
//    }
//
//
//
//    @Override
//    public CssValue visitCssValueNumber(AngularParser.CssValueNumberContext ctx) {
//        CssValue cssValue = new CssValue();
//
//        if (ctx.NUMBER() != null) {
//            String numberValue = ctx.NUMBER().getText();
//            cssValue.setNumberValue(numberValue);
//
//            // ⬅️ تسجيل cssValue
//            Row row = new Row();
//            row.setType("cssValue");
//            row.setValue(numberValue);
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return cssValue;
//    }
//
//
//
//    @Override
//    public InlineTemplate visitInlineTemplateDefinition(AngularParser.InlineTemplateDefinitionContext ctx) {
//        HtmlDocument htmlDocument = null;
//
//
//        if (ctx.htmlDocument() != null) {
//            htmlDocument = visitHtmlDocumentContent((AngularParser.HtmlDocumentContentContext) ctx.htmlDocument());
//        }
//        InlineTemplate inlineTemplate = new InlineTemplate();
//        inlineTemplate.setHtmlDocument(htmlDocument);
//
//
//        // ⬅️ تسجيل inlineTemplate
//        Row row = new Row();
//        row.setType("inlineTemplate");
//        row.setValue(String.valueOf(inlineTemplate));
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return inlineTemplate;
//    }
//
//
//
//    @Override
//    public HtmlDocument visitHtmlDocumentContent(AngularParser.HtmlDocumentContentContext ctx) {
//        HtmlDocument htmlDocument = new HtmlDocument();
//        System.out.println("Visiting HtmlDocumentContent: " + ctx.getText());
//
//
//
//        // ⬅️ تسجيل htmlDocument
//        Row row = new Row();
//        row.setType("htmlDocument");
//        row.setValue("Document with " + ctx.htmlElement().size() + " element(s)");
//        symbolTable.getRows().add(row);
//
//        if (ctx.htmlElement() != null && !ctx.htmlElement().isEmpty()) {
//            HtmlElement[] htmlElements = ctx.htmlElement().stream()
//                    .map(this::visitHtmlElement)
//                    .toArray(HtmlElement[]::new);
//            htmlDocument.setHtmlElements(htmlElements);
//        }
//
//        return htmlDocument;
//    }
//
//
//    public HtmlElement visitHtmlElement(AngularParser.HtmlElementContext ctx) {
//        HtmlElement htmlElement = new HtmlElement();
//
//        if (ctx instanceof AngularParser.HtmlStandardElementContext standardElementCtx) {
//            if (standardElementCtx.startTag() != null) {
//                String tagName = standardElementCtx.startTag().getText();
//                htmlElement.setTagName(tagName);
//
//                // ⬅️ تسجيل العنصر في جدول الرموز
//                Row row = new Row();
//                row.setType("htmlElement");
//                row.setValue("Standard Element: " + tagName);
//                row.setLine(ctx.start.getLine());
//                row.setColumn(ctx.start.getCharPositionInLine());
//                symbolTable.getRows().add(row);
//            }
//
//            if (standardElementCtx.htmlContent() != null && !standardElementCtx.htmlContent().isEmpty()) {
//                HtmlContent[] htmlContents = standardElementCtx.htmlContent().stream()
//                        .map(this::visitHtmlContent)
//                        .toArray(HtmlContent[]::new);
//                htmlElement.setHtmlContents(htmlContents);
//            }
//
//        } else if (ctx instanceof AngularParser.HtmlSelfClosingElementContext selfClosingElementCtx) {
//            htmlElement = visitHtmlSelfClosingElement(selfClosingElementCtx);
//
//            // ⬅️ تسجيل العنصر المغلق ذاتيًا في جدول الرموز
//            Row row = new Row();
//            row.setType("htmlElement");
//            row.setValue("Self-closing Element: " + htmlElement.getTagName());
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return htmlElement;
//    }
//
//
//
//
//    @Override
//    public HtmlElement visitHtmlStandardElement(AngularParser.HtmlStandardElementContext ctx) {
//        HtmlElement htmlElement = new HtmlElement();
//
//        if (ctx.startTag() != null) {
//            // استخلاص اسم الوسم من startTag
//            String tagName = ctx.startTag().getText(); // استخدام getText() لاستخراج الوسم بشكل صحيح
//            htmlElement.setTagName(tagName);
//        }
//
//        // معالجة محتوى HTML (HtmlContents)
//        if (ctx.htmlContent() != null && !ctx.htmlContent().isEmpty()) {
//            HtmlContent[] htmlContents = ctx.htmlContent().stream()
//                    .map(this::visitHtmlContent) // زيارة كل محتوى HTML باستخدام التابع visitHtmlContent
//                    .toArray(HtmlContent[]::new); // تحويل النتيجة إلى مصفوفة
//            htmlElement.setHtmlContents(htmlContents);
//        }
//
//        return htmlElement;
//    }
//
//    public HtmlContent visitHtmlContent(AngularParser.HtmlContentContext ctx) {
//        HtmlContent htmlContent = new HtmlContent();
//        // معالجة بيانات HtmlContent
//        return htmlContent;
//    }
//
//
//    @Override
//    public HtmlElement visitHtmlSelfClosingElement(AngularParser.HtmlSelfClosingElementContext ctx) {
//        HtmlElement htmlElement = new HtmlElement();
//
//        // الوصول إلى SelfClosingTagContext
//        if (ctx.selfClosingTag() != null) {
//            // استخلاص اسم الوسم (Tag Name) من خلال SelfClosingTagContext
//            String tagName = ctx.selfClosingTag().getText();
//            htmlElement.setTagName(tagName);
//        }
//
//        // الوسوم ذات الإغلاق الذاتي لا تحتوي على محتوى داخلي، لذا htmlContents تبقى فارغة
//        htmlElement.setHtmlContents(new HtmlContent[0]); // تعيين مصفوفة فارغة
//
//        return htmlElement;
//    }
//
//
//
//    @Override
//    public HtmlStartTag visitHtmlStartTag(AngularParser.HtmlStartTagContext ctx) {
//        HtmlStartTag htmlStartTag = new HtmlStartTag();
//
//        if (ctx.tagName() != null) {
//            String tagName = ctx.tagName().getText();
//            htmlStartTag.setTagName(tagName);
//
//            // ⬅️ تسجيل الوسم الافتتاحي
//            Row row = new Row();
//            row.setType("startTag");
//            row.setValue("Tag: <" + tagName + ">");
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        if (ctx.attribute() != null && !ctx.attribute().isEmpty()) {
//            Attribute[] attributes = ctx.attribute()
//                    .stream()
//                    .map(this::visitHtmlAttribute)
//                    .toArray(Attribute[]::new);
//            htmlStartTag.setAttributes(attributes);
//        }
//
//        return htmlStartTag;
//    }
//
//
//    public Attribute visitHtmlAttribute(AngularParser.AttributeContext ctx) {
//        Attribute attribute = new Attribute();
//        String name = null;
//        String value = null;
//
//        if (ctx instanceof AngularParser.HtmlAttributeBasicContext basicCtx) {
//            name = basicCtx.IDENTIFIER().getText();
//            value = basicCtx.attributeValue() != null ? basicCtx.attributeValue().getText() : null;
//        } else if (ctx instanceof AngularParser.HtmlAttributeBindingContext bindingCtx) {
//            name = bindingCtx.BINDING().getText();
//            value = bindingCtx.attributeValue() != null ? bindingCtx.attributeValue().getText() : null;
//        } else if (ctx instanceof AngularParser.HtmlAttributeStructuralContext structuralCtx) {
//            name = structuralCtx.STRUCTURAL_DIRECTIVE().getText();
//            value = structuralCtx.attributeValue() != null ? structuralCtx.attributeValue().getText() : null;
//        } else if (ctx instanceof AngularParser.HtmlAttributeEventBindingContext eventBindingCtx) {
//            name = eventBindingCtx.EVENT_BINDING().getText();
//            value = eventBindingCtx.attributeValue() != null ? eventBindingCtx.attributeValue().getText() : null;
//        } else if (ctx instanceof AngularParser.HtmlAttributeClassContext classCtx) {
//            name = classCtx.CLASS().getText();
//            value = classCtx.attributeValue() != null ? classCtx.attributeValue().getText() : null;
//        }
//
//        attribute.setName(name);
//        attribute.setValue(value);
//
//        // ⬅️ تسجيل السمة في جدول الرموز
//        Row row = new Row();
//        row.setType("attribute");
//        row.setValue(name + (value != null ? (" = " + value) : ""));
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//        return attribute;
//    }
//
//
//
//    @Override
//    public HtmlEndTag visitHtmlEndTag(AngularParser.HtmlEndTagContext ctx) {
//        HtmlEndTag htmlEndTag = new HtmlEndTag();
//
//        if (ctx.tagName() != null) {
//            String tagName = ctx.tagName().getText();
//            htmlEndTag.setTagName(tagName);
//
//            // ⬅️ تسجيل الوسم الختامي
//            Row row = new Row();
//            row.setType("endTag");
//            row.setValue("Tag: </" + tagName + ">");
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return htmlEndTag;
//    }
//
//
//
//    @Override
//    public HtmlSelfClosingTag visitHtmlSelfClosingTag(AngularParser.HtmlSelfClosingTagContext ctx) {
//        HtmlSelfClosingTag htmlSelfClosingTag = new HtmlSelfClosingTag();
//
//        // استخراج اسم الوسم (Tag Name)
//        if (ctx.SELF_CLOSE() != null) {
//            htmlSelfClosingTag.setTagName(ctx.SELF_CLOSE().getText());
//        }
//
//        // معالجة الخصائص (Attributes) إذا وجدت
//        if (ctx.attribute() != null && !ctx.attribute().isEmpty()) {
//            Attribute[] attributes = ctx.attribute().stream()
//                    .map(this::visitHtmlAttribute) // زيارة كل خاصية
//                    .toArray(Attribute[]::new);
//            htmlSelfClosingTag.setAttributes(attributes);
//        }
//
//        return htmlSelfClosingTag;
//    }
//
//
//    @Override
//    public Object visitHtmlNestedElement(AngularParser.HtmlNestedElementContext ctx) {
//        // ⬅️ تسجيل العنصر المتداخل
//        Row row = new Row();
//        row.setType("nestedElement");
//        row.setValue("Nested Element: " + ctx.getText());
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return visitChildren(ctx);
//    }
//
//
//    @Override
//    public Object visitHtmlTextContent(AngularParser.HtmlTextContentContext ctx) {
//        String text = ctx.getText().trim();
//        if (!text.isEmpty()) {
//            // ⬅️ تسجيل المحتوى النصي
//            Row row = new Row();
//            row.setType("textContent");
//            row.setValue("Text: " + text);
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return visitChildren(ctx);
//    }
//
//
//    @Override
//    public Object visitHtmlTemplateExpression(AngularParser.HtmlTemplateExpressionContext ctx) {
//        String expression = ctx.getText();
//
//        // ⬅️ تسجيل تعبير القالب
//        Row row = new Row();
//        row.setType("templateExpression");
//        row.setValue("Expression: " + expression);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return visitChildren(ctx);
//    }
//
//
//    @Override
//    public HtmlTagName visitHtmlTagName(AngularParser.HtmlTagNameContext ctx) {
//        HtmlTagName htmlTagName = new HtmlTagName();
//
//        if (ctx.IDENTIFIER() != null) {
//            String tagName = ctx.IDENTIFIER().getText();
//            htmlTagName.setTagName(tagName);
//
//            // ⬅️ تسجيل اسم الوسم
//            Row row = new Row();
//            row.setType("tagName");
//            row.setValue("Tag Name: " + tagName);
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return htmlTagName;
//    }
//
//
//
//    @Override
//    public HtmlAttributeBasic visitHtmlAttributeBasic(AngularParser.HtmlAttributeBasicContext ctx) {
//        HtmlAttributeBasic htmlAttributeBasic = new HtmlAttributeBasic();
//
//        if (ctx.EQUAL() != null) {
//            htmlAttributeBasic.setAttributeName(ctx.EQUAL().getText());
//        }
//
//        if (ctx.IDENTIFIER() != null) {
//            String value = ctx.IDENTIFIER().getText();
//            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
//                value = value.substring(1, value.length() - 1);
//            }
//            htmlAttributeBasic.setAttributeValue(value);
//
//            // ⬅️ تسجيل السمة الأساسية
//            Row row = new Row();
//            row.setType("attributeBasic");
//            row.setValue("Basic Attribute: " + htmlAttributeBasic.getAttributeName() + " = " + value);
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return htmlAttributeBasic;
//    }
//
//
//
//    @Override
//    public HtmlAttributeClass visitHtmlAttributeClass(AngularParser.HtmlAttributeClassContext ctx) {
//        HtmlAttributeClass htmlAttributeClass = new HtmlAttributeClass();
//
//        if (ctx.CLASS() != null) {
//            String value = ctx.CLASS().getText();
//            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
//                value = value.substring(1, value.length() - 1);
//            }
//
//            htmlAttributeClass.setAttributeValue(value);
//
//            // ⬅️ تسجيل الخاصية class
//            Row row = new Row();
//            row.setType("attributeClass");
//            row.setValue("Class Attribute: " + value);
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return htmlAttributeClass;
//    }
//
//
//
//    @Override
//    public HtmlAttributeStructural visitHtmlAttributeStructural(AngularParser.HtmlAttributeStructuralContext ctx) {
//        HtmlAttributeStructural htmlAttributeStructural = new HtmlAttributeStructural();
//
//        if (ctx.STRUCTURAL_DIRECTIVE() != null) {
//            String value = ctx.STRUCTURAL_DIRECTIVE().getText();
//            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
//                value = value.substring(1, value.length() - 1);
//            }
//
//            htmlAttributeStructural.setAttributeValue(value);
//
//            // ⬅️ تسجيل الخاصية الهيكلية
//            Row row = new Row();
//            row.setType("attributeStructural");
//            row.setValue("Structural Directive: " + value);
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return htmlAttributeStructural;
//    }
//
//
//
//    @Override
//    public HtmlAttributeBinding visitHtmlAttributeBinding(AngularParser.HtmlAttributeBindingContext ctx) {
//        HtmlAttributeBinding htmlAttributeBinding = new HtmlAttributeBinding();
//
//        if (ctx.BINDING() != null) {
//            String value = ctx.BINDING().getText();
//
//            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
//                value = value.substring(1, value.length() - 1);
//            }
//
//            htmlAttributeBinding.setAttributeValue(value);
//
//            // إضافة Row إلى جدول الرموز إذا كان binding يحتوي على directive (مثل *ngIf)
//            if (ctx.getParent().getText().contains("*")) {
//                Row row = new Row();
//                row.setType("attributeStructural");
//                row.setValue("Structural Directive: " + value);
//                row.setLine(ctx.start.getLine());
//                row.setColumn(ctx.start.getCharPositionInLine());
//                symbolTable.getRows().add(row);
//            }
//        }
//
//        return htmlAttributeBinding;
//    }
//
//
//
//    @Override
//    public HtmlAttributeEventBinding visitHtmlAttributeEventBinding(AngularParser.HtmlAttributeEventBindingContext ctx) {
//        HtmlAttributeEventBinding htmlAttributeEventBinding = new HtmlAttributeEventBinding();
//
//        if (ctx.EVENT_BINDING() != null) {
//            String value = ctx.EVENT_BINDING().getText();
//
//            String functionName = value.replaceAll("[()]", "");
//
//
////            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
////                value = value.substring(1, value.length() - 1);
////            }
//
//            htmlAttributeEventBinding.setAttributeValue(value);
//
//            // إضافة إلى جدول الرموز
//            Row row = new Row();
//            row.setType("eventBinding");
//            // row.setValue("Event Binding: " + value);
//            row.setValue(functionName); // تخزين اسم الدالة فقط
//
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return htmlAttributeEventBinding;
//    }
//
//
//    @Override
//    public HtmlAttributeValue visitHtmlAttributeValue(AngularParser.HtmlAttributeValueContext ctx) {
//        HtmlAttributeValue htmlAttributeValue = new HtmlAttributeValue();
//
//        if (ctx.STRING() != null) {
//            String value = ctx.STRING().getText();
//
//            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
//                value = value.substring(1, value.length() - 1);
//            }
//
//            htmlAttributeValue.setValue(value);
//
//            // إضافة إلى جدول الرموز
//            Row row = new Row();
//            row.setType("attributeValue");
//            row.setValue("Attribute Value: " + value);
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        return htmlAttributeValue;
//    }
//
//
//    @Override
//    public TypeScriptClass visitTypeScriptClassDefinition(AngularParser.TypeScriptClassDefinitionContext ctx) {
//
//        TypeScriptClass typeScriptClass = new TypeScriptClass();
//
//        // استخراج اسم الكلاس من السياق
//        if (ctx.EXPORT() != null) {
//            String className = ctx.EXPORT().getText();
//            typeScriptClass.setClassName(className);
//        }
//
//        // استخراج جسم الكلاس من السياق
//        if (ctx.classBody() != null) {
//            ClassBody classBody = visitClassBodyContent((AngularParser.ClassBodyContentContext) ctx.classBody());  // افترض وجود طريقة لزيارة ClassBody
//            typeScriptClass.setClassBody(classBody);
//        }
//
//        return typeScriptClass;
//    }
//
//
//    @Override
//    public ClassBody visitClassBodyContent(AngularParser.ClassBodyContentContext ctx) {
//        System.out.println("Visiting class body..."); // Debug line
//
//        ClassBody classBody = new ClassBody();
//
//
//        // استخراج أعضاء الكلاس من السياق
//        List<ClassMember> classMembersList = new ArrayList<>();
//
//        for (AngularParser.ClassMemberContext memberContext : ctx.classMember()) {
//            // زيارة كل عضو من أعضاء الكلاس
//            ClassMember classMember = new ClassMember(memberContext);  // افترض وجود طريقة لزيارة ClassMember
//            classMembersList.add(classMember);
//        }
//        for (AngularParser.ClassMemberContext memberCtx : ctx.classMember()) {
//            // فقط قم بزيارة كل عضو، والزيارات الأخرى (مثل property أو method) ستُستدعى تلقائيًا
//            visit(memberCtx);
//        }
//
//        // تحويل القائمة إلى مصفوفة وتعيينها
//        classBody.setClassMembers(classMembersList.toArray(new ClassMember[0]));
//
//        return classBody;
//    }
//
//
////    @Override
////    public ClassBody visitClassBodyContent(AngularParser.ClassBodyContentContext ctx) {
////
////        ClassBody classBody = new ClassBody();
////
////        for (AngularParser.ClassMemberContext memberCtx : ctx.classMember()) {
////            // فقط قم بزيارة كل عضو، والزيارات الأخرى (مثل property أو method) ستُستدعى تلقائيًا
////            visit(memberCtx);
////        }
////
////        return classBody;
////    }
////
//
//    @Override
//    public Object visitClassProperty(AngularParser.ClassPropertyContext ctx) {
//        // معالجة بيانات Class Property
//        return visitChildren(ctx);
//    }
//
//    @Override
//    public Object visitClassMethod(AngularParser.ClassMethodContext ctx) {
//        // معالجة بيانات Class Method
//        return visitChildren(ctx);
//    }
//
//    @Override
////    public PropertyDeclaration visitPropertyDeclarationStatement(AngularParser.PropertyDeclarationStatementContext ctx) {
////        PropertyDeclaration propertyDeclaration = new PropertyDeclaration();
////
////        // استخراج اسم الخاصية (identifier) من السياق
////        String identifier = ctx.IDENTIFIER().getText();
////        propertyDeclaration.setIdentifier(identifier);
////
////        // استخراج قيمة الخاصية (value) من السياق
////        String value = ctx.literal().getText();
////        propertyDeclaration.setValue(value);
////
////        // إضافة إلى جدول الرموز
////        Row row = new Row();
////      //  row.setType("attributeStructural");
////        row.setType("classProperty");
////
////        row.setValue(identifier + " = " + value);
////
////     //   row.setValue("Structural Directive: " + value);
////        row.setLine(ctx.start.getLine());
////        row.setColumn(ctx.start.getCharPositionInLine());
////        symbolTable.getRows().add(row);
////
////        return propertyDeclaration;
////    }
//    public PropertyDeclaration visitPropertyDeclarationStatement(AngularParser.PropertyDeclarationStatementContext ctx) {
//        PropertyDeclaration propertyDeclaration = new PropertyDeclaration();
//
//        // Extract property name (identifier)
//        String identifier = ctx.IDENTIFIER().getText();
//        propertyDeclaration.setIdentifier(identifier);
//
//        // Handle value (which may be null)
//        String value = null;
//        if (ctx.literal() != null) {
//            value = ctx.literal().getText();
//        }
//        propertyDeclaration.setValue(value);
//
//        // Add to symbol table
//        Row row = new Row();
//        row.setType("classProperty");
//        row.setValue(identifier);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//
//        ///////////////////////////////////////////
//        // تحديث الجداول المخصصة مباشرة
////        ngForSymbolTable.addComponentVariable(identifier);
////        templateVarSymbolTable.addComponentVariable(identifier);
////        unsafeAccessSymbolTable.addClassProperty(identifier, false); // أو true إذا كان nullable
////        ///////////////////////////////////////////
//        return propertyDeclaration;
//    }
//
//
//
//
//
//    @Override
//    public MethodDeclaration visitMethodDeclarationDefinition(AngularParser.MethodDeclarationDefinitionContext ctx) {
//        MethodDeclaration methodDeclaration = new MethodDeclaration();
//
//        // استخراج اسم الدالة (methodName) من السياق
//        String methodName = ctx.IDENTIFIER().getText();
//        methodDeclaration.setMethodName(methodName);
//
//        // استخراج قائمة المعاملات (parameterList) من السياق
//        ParameterList parameterList = (ParameterList) visitMethodParameterList((AngularParser.MethodParameterListContext) ctx.parameterList());
//        methodDeclaration.setParameterList(parameterList);
//
//        // استخراج جسم الدالة (methodBody) من السياق
//        MethodBody methodBody = visitMethodBodyContent((AngularParser.MethodBodyContentContext) ctx.methodBody());
//        methodDeclaration.setMethodBody(methodBody);
//
//        // إضافة إلى جدول الرموز
//        Row row = new Row();
////        row.setType("attributeStructural");
////        row.setValue("Structural Directive: " + methodName);
//
//        row.setType("methodDeclaration");
//        row.setValue(methodName);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return methodDeclaration;
//    }
//
//
//
//    @Override
//    public ParameterList visitMethodParameterList(AngularParser.MethodParameterListContext ctx) {
//        ParameterList parameterList = new ParameterList();
//
//        // استخراج أسماء المعاملات مباشرة من الـ IDENTIFIER
//        List<String> parameterNames = new ArrayList<>();
//        for (TerminalNode id : ctx.IDENTIFIER()) {
//            parameterNames.add(id.getText());
//        }
//
//        parameterList.setParameters(parameterNames.toArray(new String[0]));
//        return parameterList;
//    }
//
//
//    @Override
//    public MethodBody visitMethodBodyContent(AngularParser.MethodBodyContentContext ctx) {
//        MethodBody methodBody = new MethodBody();
//
//        // استخراج البيانات المتعلقة بالـ Statements (البيانات الداخلية للجسم)
//        List<Statement> statementsList = new ArrayList<>();
//
//        // استخراج كل بيان داخل الجسم وإضافته إلى القائمة
//        for (AngularParser.StatementContext stmtCtx : ctx.statement()) {
//            Statement statement = new Statement();
//
//            // معالجة البيان هنا (مثال على استخراج البيانات)
//            // يجب أن يتم تحديد كيف يتم استخراج البيانات من البيان.
//            String statementText = stmtCtx.getText();  // على سبيل المثال، استخراج النص الخاص بالبيان
//
//            statement.setExpression(statementText);  // تعيين النص في البيان
//            statementsList.add(statement);  // إضافة البيان إلى القائمة
//        }
//
//        // تحويل القائمة إلى مصفوفة وتعيينها
//        methodBody.setStatements(statementsList.toArray(new Statement[0]));
//
//        return methodBody;
//    }
//
//
//    @Override
//    public Expression visitExpressionStatement(AngularParser.ExpressionStatementContext ctx) {
//        Expression expression = new Expression();
//
//        String identifier = ctx.getText();
//        expression.setIdentifier(identifier);
//        expression.setValue(identifier);
//
//        Row row = new Row();
//        row.setType("attributeStructural");
//        row.setValue("Structural Directive: " + identifier);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return expression;
//    }
//
//
//
//    @Override
//    public TestBlock visitBlockStatement(AngularParser.BlockStatementContext ctx) {
//        TestBlock testBlock = new TestBlock();
//        List<AngularExpression> angularExpressions = new ArrayList<>();
//
//        for (AngularParser.StatementContext stmtCtx : ctx.statement()) {
//            if (stmtCtx instanceof AngularParser.ExpressionStatementContext) {
//                AngularParser.ExpressionStatementContext exprStmt =
//                        (AngularParser.ExpressionStatementContext) stmtCtx;
//
//                AngularParser.ExpressionContext exprCtx = exprStmt.expression();
//
//                AngularExpression angularExpression = new AngularExpression();
//                angularExpression.setStringExpression(exprCtx.getText());
//
//                angularExpressions.add(angularExpression);
//            }
//            // يمكنك معالجة functionCallStatement هنا أيضًا إن أردت
//        }
//
//        testBlock.setAngularExpressions(angularExpressions);
//        return testBlock;
//    }
//
//    @Override
//    public FunctionCall visitFunctionCallStatement(AngularParser.FunctionCallStatementContext ctx) {
//        FunctionCall functionCall = new FunctionCall();
//
//        AngularParser.FunctionCallDefinitionContext fcCtx = (AngularParser.FunctionCallDefinitionContext) ctx.functionCall();
//
//        // استخراج اسم الدالة
//        functionCall.setFunctionName(fcCtx.functionName.getText());
//
//        // إنشاء قائمة الوسائط
//        ArgumentList argumentList = new ArgumentList();
//        List<Expression> expressions = new ArrayList<>();
//
//        if (fcCtx.args != null) {
//            for (AngularParser.ExpressionContext exprCtx : fcCtx.args.expression()) {
//                Expression expr = new Expression();
//                expr.setValue(exprCtx.getText());
//                expressions.add(expr);
//            }
//        }
//
//        argumentList.setExpressions(expressions.toArray(new Expression[0]));
//        functionCall.setArgumentList(argumentList);
//
//        return functionCall;
//    }
//
//    @Override
//    public Object visitAssignmentExpression(AngularParser.AssignmentExpressionContext ctx) {
//        // معالجة بيانات Assignment Expression
//        return visitChildren(ctx);
//    }
//
//    @Override
//    public Object visitIdentifierExpression(AngularParser.IdentifierExpressionContext ctx) {
//        // معالجة بيانات Identifier Expression
//        return visitChildren(ctx);
//    }
//
//
//
//
//    @Override
//    public Object visitStringExpression(AngularParser.StringExpressionContext ctx) {
//        // معالجة بيانات String Expression
//        return visitChildren(ctx);
//    }
//
//    @Override
//    public Object visitNumberExpression(AngularParser.NumberExpressionContext ctx) {
//        // معالجة بيانات Number Expression
//        return visitChildren(ctx);
//    }
//
//    @Override
//    public Object visitThisAssignmentExpression(AngularParser.ThisAssignmentExpressionContext ctx) {
//        // معالجة بيانات This Assignment Expression
//        return visitChildren(ctx);
//    }
//
//    @Override
//    public Object visitFunctionCallDefinition(AngularParser.FunctionCallDefinitionContext ctx) {
//        // معالجة بيانات Function Call Definition
//        return visitChildren(ctx);
//    }
//
//    @Override
//    public TestBlock visitTestBlock(AngularParser.TestBlockContext ctx) {
//        TestBlock testBlock = new TestBlock();
//        List<AngularExpression> angularExpressions = new ArrayList<>();
//
//        for (AngularParser.AngularExpressionContext exprCtx : ctx.angularExpression()) {
//            AngularExpression angularExpression = new AngularExpression();
//            String expressionValue = exprCtx.getText();
//            angularExpression.setStringExpression(expressionValue);
//            angularExpressions.add(angularExpression);
//
//            Row row = new Row();
//            row.setType("attributeStructural");
//            row.setValue("Structural Directive: " + expressionValue);
//            row.setLine(ctx.start.getLine());
//            row.setColumn(ctx.start.getCharPositionInLine());
//            symbolTable.getRows().add(row);
//        }
//
//        testBlock.setAngularExpressions(angularExpressions);
//        return testBlock;
//    }
//
//
//
//    @Override
//    public NullLiteral visitNullLiteral(AngularParser.NullLiteralContext ctx) {
//        // إنشاء كائن NullLiteral
//        NullLiteral nullLiteral = new NullLiteral();
//
//        // لا توجد معالجة إضافية لأنه لا يوجد بيانات أخرى في NullLiteral
//
//        // إرجاع الكائن NullLiteral
//        return nullLiteral;
//    }
//
//
//    @Override
//    public StringLiteral visitStringLiteral(AngularParser.StringLiteralContext ctx) {
//        StringLiteral stringLiteral = new StringLiteral();
//        String value = ctx.getText();
//        stringLiteral.setValue(value);
//
//        Row row = new Row();
//        row.setType("attributeStructural");
//        row.setValue("Structural Directive: " + value);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return stringLiteral;
//    }
//
//
//
//    @Override
//    public NumberLiteral visitNumberLiteral(AngularParser.NumberLiteralContext ctx) {
//        NumberLiteral numberLiteral = new NumberLiteral();
//        String valueText = ctx.getText();
//        double value = Double.parseDouble(valueText);
//        numberLiteral.setValue(value);
//
//        Row row = new Row();
//        row.setType("attributeStructural");
//        row.setValue("Structural Directive: " + valueText);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return numberLiteral;
//    }
//
//
//
//    @Override
//    public AngularIdentifierExpression visitAngularIdentifierExpression(AngularParser.AngularIdentifierExpressionContext ctx) {
//        AngularIdentifierExpression angularIdentifierExpression = new AngularIdentifierExpression();
//        String identifier = ctx.getText();
//        angularIdentifierExpression.setIdentifier(identifier);
//
//        Row row = new Row();
//        row.setType("attributeStructural");
//        row.setValue("Structural Directive: " + identifier);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return angularIdentifierExpression;
//    }
//
//
//
//    @Override
//    public AngularStringExpression visitAngularStringExpression(AngularParser.AngularStringExpressionContext ctx) {
//        AngularStringExpression angularStringExpression = new AngularStringExpression();
//
//        // استخراج قيمة السلسلة النصية من ctx
//        String value = ctx.getText();
//        angularStringExpression.setValue(value);
//
//        // تسجيل البيان في جدول الرموز
//        Row row = new Row();
//        row.setType("attributeStructural");
//        row.setValue("Structural Directive: " + value);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return angularStringExpression;
//    }
//
//
//
//    @Override
//    public AngularTemplateExpression visitAngularTemplateExpression(AngularParser.AngularTemplateExpressionContext ctx) {
//        AngularTemplateExpression angularTemplateExpression = new AngularTemplateExpression();
//
//        // استخراج القالب النصي من ctx
//        String template = ctx.getText();
//        angularTemplateExpression.setTemplate(template);
//
//        // تسجيل البيان في جدول الرموز
//        Row row = new Row();
//        row.setType("attributeStructural");
//        row.setValue("Structural Directive: " + template);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return angularTemplateExpression;
//    }
//
//
//}


package classes;

import AngularGen.AngularParser;
import AngularGen.AngularParserBaseVisitor;
import org.antlr.v4.runtime.CharStream;
import org.antlr.v4.runtime.Token;
import org.antlr.v4.runtime.misc.Interval;
import org.antlr.v4.runtime.tree.ParseTree;
import org.antlr.v4.runtime.tree.TerminalNode;
import semantic_check.ErrorType;
import semantic_check.SemanticAnalyzer;
import semantic_check.SemanticError;
import semantic_check.TemplateWithLines;

import symbol_table.Row;
import symbol_table.SymbolTable;

import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;


public class BaseVisitor extends AngularParserBaseVisitor {
    SymbolTable symbolTable = new SymbolTable();
    private SemanticAnalyzer analyzer = new SemanticAnalyzer(symbolTable);


    @Override
    public Application visitApplicationRoot(AngularParser.ApplicationRootContext ctx) {
        Application application = new Application();
        for (int i = 0; i < ctx.component().size(); i++) {
            if (ctx.component(i) != null) {
                Component component = (Component) visit(ctx.component(i));
                application.getComponents().add(component);
            }
        }
        analyzer.analyze();

//        analyzer.checkComponentRequirements();
//        analyzer.checkNgForWithoutSource();
//        analyzer.checkConditionalAccess();
//        List<Row> Error = new ArrayList<>();
//        TemplateVariablesSymbolTable.printRelatedSymbolTable(Error);
        // تحويل SymbolTable العام إلى الجداول المخصصة
//        convertToCustomSymbolTables();


        analyzer.printErrors();
        this.symbolTable.print();
        return application;
    }

    @Override
    public Object visitImportStatementDefinition(AngularParser.ImportStatementDefinitionContext ctx) {
        String importedVar = ctx.IDENTIFIER().getText();

        Row row = new Row();
        row.setType("importedVar");
        row.setValue(importedVar);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return null;
    }



    @Override
    public Component visitComponentDefinition(AngularParser.ComponentDefinitionContext ctx) {
        Component component = new Component();

        Row row = new Row();
        row.setType("component");
        row.setValue("@Component"); // يمكنك وضع اسم حقيقي إذا توفر لاحقًا
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        if (ctx.componentMetadata() == null) {
            analyzer.getErrors().add(new SemanticError(
                    "Missing component metadata",
                    "Component must have metadata",
                    ctx.start.getLine(),
                    ctx.start.getCharPositionInLine(),
                    ErrorType.SEMANTIC
            ));
        }
        // معالجة metadata
        else {
            ComponentMetadata metadata = (ComponentMetadata) visit(ctx.componentMetadata());
            component.setComponentMetadata(metadata);
        }

        // معالجة TypeScript class
        if (ctx.typeScriptClass() != null) {
            TypeScriptClass tsClass = (TypeScriptClass) visit(ctx.typeScriptClass());
            component.setTypeScriptClass(tsClass);
        }

        return component;
    }

    @Override
    public ComponentMetadata visitComponentMetadataDefinition(AngularParser.ComponentMetadataDefinitionContext ctx) {
        ComponentMetadata componentMetadata = new ComponentMetadata();

        for (int i = 0; i < ctx.metadataEntry().size(); i++) {
            ParseTree tree = ctx.metadataEntry(i);
            MetadataEntry entry = (MetadataEntry) visit(tree);
            componentMetadata.getMetadataEntries().add(entry);
        }

        return componentMetadata;
    }


    public MetadataEntry visitMetadataSelector(AngularParser.MetadataSelectorContext ctx) {
        String selector =  ctx.attributeValue().getText();

        if (selector == null || selector.isEmpty()) {
            analyzer.getErrors().add(new SemanticError(
                    "Missing Selector",
                    "Component must have Selector",
                    ctx.start.getLine(),
                    ctx.start.getCharPositionInLine(),
                    ErrorType.SEMANTIC
            ));
        }

        Row row = new Row();
        row.setType("selector");
        row.setValue(selector);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return new SelectorEntry(selector);
    }

    @Override
    public MetadataEntry visitMetadataTemplate(AngularParser.MetadataTemplateContext ctx) {
        if (ctx.inlineTemplate() == null) {
            analyzer.addError("Missing component template",
                    "Component must have template",
                    ctx.start.getLine(),
                    ctx.start.getCharPositionInLine());
            return null;
        }

        // الحصول على المحتوى مع الحفاظ على الأسطر الأصلية
        String templateContent = getOriginalTemplateText(ctx.inlineTemplate());
        int templateStartLine = ctx.inlineTemplate().start.getLine();

        TemplateWithLines templateWithLines = new TemplateWithLines(templateContent, templateStartLine);

        Row row = new Row();
        row.setType("template");
        row.setValue(templateContent);
        row.setLine(templateStartLine);
        row.setColumn(ctx.inlineTemplate().start.getCharPositionInLine());
        row.setAdditionalData(templateWithLines);
        symbolTable.getRows().add(row);



//        return new TemplateEntry(new InlineTemplate(templateContent));
        HtmlDocument htmlDocument = null;
        AngularParser.InlineTemplateContext inlineCtx = ctx.inlineTemplate();
        if (inlineCtx instanceof AngularParser.InlineTemplateDefinitionContext defCtx
                && defCtx.htmlDocument() != null) {
            htmlDocument = visitHtmlDocumentContent(
                    (AngularParser.HtmlDocumentContentContext) defCtx.htmlDocument());
        }
        InlineTemplate inlineTemplate = new InlineTemplate(templateContent);
        inlineTemplate.setHtmlDocument(htmlDocument);
        return new TemplateEntry(inlineTemplate);
    }

    private String getOriginalTemplateText(AngularParser.InlineTemplateContext ctx) {
        Token startToken = ctx.getStart();
        Token endToken = ctx.getStop();
        CharStream input = startToken.getInputStream();
        return input.getText(Interval.of(startToken.getStartIndex(), endToken.getStopIndex()));
    }
    @Override
    public MetadataEntry visitMetadataStyles(AngularParser.MetadataStylesContext ctx) {
        StylesContent styles = new StylesContent(ctx.stylesContent().getText());

        Row row = new Row();
        row.setType("styles");
        row.setValue(styles.toString());
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return new StylesEntry(styles);
    }

    @Override
    public StylesContent visitStylesContentBlock(AngularParser.StylesContentBlockContext ctx) {
        StylesContent stylesContent = new StylesContent();

        Row row = new Row();
        row.setType("stylesContent");
        row.setValue(stylesContent.toString());
        symbolTable.getRows().add(row);

        for (int i = 0; i < ctx.cssContent().size(); i++) {
            if (ctx.cssContent(i) != null) {
                CssContent cssContent = (CssContent) visit(ctx.cssContent(i));
                stylesContent.getCssContents().add(cssContent);
            }
        }

        return stylesContent;
    }


    @Override
    public CssContent visitCssContentRules(AngularParser.CssContentRulesContext ctx) {
        CssContent cssContent = new CssContent();

        Row row = new Row();
        row.setType("cssContent");
        row.setValue(cssContent.toString());
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        for (int i = 0; i < ctx.cssRule().size(); i++) {
            if (ctx.cssRule(i) != null) {
                CssRule cssRule = (CssRule) visit(ctx.cssRule(i));
                cssContent.getCssRules().add(cssRule);
            }
        }

        return cssContent;
    }


    @Override
    public CssRule visitCssRuleDefinition(AngularParser.CssRuleDefinitionContext ctx) {
        CssRule cssRule = new CssRule();

        if (ctx.CSS_SELECTOR() != null) {
            cssRule.setSelector(ctx.CSS_SELECTOR().getText());
        }

        // ⬅️ تسجيل cssRule
        Row row = new Row();
        row.setType("cssRule");
        row.setValue(cssRule.getSelector() != null ? cssRule.getSelector() : "anonymous rule");
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        for (int i = 0; i < ctx.cssDeclaration().size(); i++) {
            if (ctx.cssDeclaration(i) != null) {
                CssDeclaration declaration = (CssDeclaration) visit(ctx.cssDeclaration(i));
                cssRule.getDeclarations().add(declaration);
            }
        }

        return cssRule;
    }



    @Override
    public CssDeclaration visitCssDeclarationEntry(AngularParser.CssDeclarationEntryContext ctx) {
        CssDeclaration cssDeclaration = new CssDeclaration();

        if (ctx.CSS_PROPERTY() != null) {
            cssDeclaration.setProperty(ctx.CSS_PROPERTY().getText());
        }

        if (ctx.cssValue() != null) {
            cssDeclaration.setValue(ctx.cssValue().getText());
        }

        // ⬅️ تسجيل cssDeclaration
        Row row = new Row();
        row.setType("cssDeclaration");
        row.setValue(cssDeclaration.getProperty() + ": " + cssDeclaration.getValue());
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return cssDeclaration;
    }



    @Override
    public CssValue visitCssValuePercentage(AngularParser.CssValuePercentageContext ctx) {
        CssValue cssValue = new CssValue();

        if (ctx.PERCENTAGE() != null) {
            cssValue.setPercentageValue(ctx.PERCENTAGE().getText());

            // ⬅️ تسجيل cssValue
            Row row = new Row();
            row.setType("cssValue");
            row.setValue(cssValue.getPercentageValue());
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return cssValue;
    }



    @Override
    public CssValue visitCssValueNumber(AngularParser.CssValueNumberContext ctx) {
        CssValue cssValue = new CssValue();

        if (ctx.NUMBER() != null) {
            String numberValue = ctx.NUMBER().getText();
            cssValue.setNumberValue(numberValue);

            // ⬅️ تسجيل cssValue
            Row row = new Row();
            row.setType("cssValue");
            row.setValue(numberValue);
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return cssValue;
    }



    @Override
    public InlineTemplate visitInlineTemplateDefinition(AngularParser.InlineTemplateDefinitionContext ctx) {
        HtmlDocument htmlDocument = null;


        if (ctx.htmlDocument() != null) {
            htmlDocument = visitHtmlDocumentContent((AngularParser.HtmlDocumentContentContext) ctx.htmlDocument());
        }
        InlineTemplate inlineTemplate = new InlineTemplate();
        inlineTemplate.setHtmlDocument(htmlDocument);


        // ⬅️ تسجيل inlineTemplate
        Row row = new Row();
        row.setType("inlineTemplate");
        row.setValue(String.valueOf(inlineTemplate));
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return inlineTemplate;
    }



    @Override
    public HtmlDocument visitHtmlDocumentContent(AngularParser.HtmlDocumentContentContext ctx) {
        HtmlDocument htmlDocument = new HtmlDocument();
        System.out.println("Visiting HtmlDocumentContent: " + ctx.getText());



        // ⬅️ تسجيل htmlDocument
        Row row = new Row();
        row.setType("htmlDocument");
        row.setValue("Document with " + ctx.htmlElement().size() + " element(s)");
        symbolTable.getRows().add(row);

        if (ctx.htmlElement() != null && !ctx.htmlElement().isEmpty()) {
            HtmlElement[] htmlElements = ctx.htmlElement().stream()
                    .map(this::visitHtmlElement)
                    .toArray(HtmlElement[]::new);
            htmlDocument.setHtmlElements(htmlElements);
        }

        return htmlDocument;
    }


    public HtmlElement visitHtmlElement(AngularParser.HtmlElementContext ctx) {
        HtmlElement htmlElement = new HtmlElement();

        if (ctx instanceof AngularParser.HtmlStandardElementContext standardElementCtx) {
            if (standardElementCtx.startTag() != null) {
                String tagName = standardElementCtx.startTag().getText();
                htmlElement.setTagName(tagName);

                // ⬅️ تسجيل العنصر في جدول الرموز
                Row row = new Row();
                row.setType("htmlElement");
                row.setValue("Standard Element: " + tagName);
                row.setLine(ctx.start.getLine());
                row.setColumn(ctx.start.getCharPositionInLine());
                symbolTable.getRows().add(row);
            }

            if (standardElementCtx.htmlContent() != null && !standardElementCtx.htmlContent().isEmpty()) {
                HtmlContent[] htmlContents = standardElementCtx.htmlContent().stream()
                        .map(this::visitHtmlContent)
                        .toArray(HtmlContent[]::new);
                htmlElement.setHtmlContents(htmlContents);
            }

        } else if (ctx instanceof AngularParser.HtmlSelfClosingElementContext selfClosingElementCtx) {
            htmlElement = visitHtmlSelfClosingElement(selfClosingElementCtx);

            // ⬅️ تسجيل العنصر المغلق ذاتيًا في جدول الرموز
            Row row = new Row();
            row.setType("htmlElement");
            row.setValue("Self-closing Element: " + htmlElement.getTagName());
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return htmlElement;
    }




    @Override
    public HtmlElement visitHtmlStandardElement(AngularParser.HtmlStandardElementContext ctx) {
        HtmlElement htmlElement = new HtmlElement();

        if (ctx.startTag() != null) {
            // استخلاص اسم الوسم من startTag
            String tagName = ctx.startTag().getText(); // استخدام getText() لاستخراج الوسم بشكل صحيح
            htmlElement.setTagName(tagName);
        }

        // معالجة محتوى HTML (HtmlContents)
        if (ctx.htmlContent() != null && !ctx.htmlContent().isEmpty()) {
            HtmlContent[] htmlContents = ctx.htmlContent().stream()
                    .map(this::visitHtmlContent) // زيارة كل محتوى HTML باستخدام التابع visitHtmlContent
                    .toArray(HtmlContent[]::new); // تحويل النتيجة إلى مصفوفة
            htmlElement.setHtmlContents(htmlContents);
        }

        return htmlElement;
    }

    public HtmlContent visitHtmlContent(AngularParser.HtmlContentContext ctx) {
        HtmlContent htmlContent = new HtmlContent();
        // معالجة بيانات HtmlContent
        return htmlContent;
    }


    @Override
    public HtmlElement visitHtmlSelfClosingElement(AngularParser.HtmlSelfClosingElementContext ctx) {
        HtmlElement htmlElement = new HtmlElement();

        // الوصول إلى SelfClosingTagContext
        if (ctx.selfClosingTag() != null) {
            // استخلاص اسم الوسم (Tag Name) من خلال SelfClosingTagContext
            String tagName = ctx.selfClosingTag().getText();
            htmlElement.setTagName(tagName);
        }

        // الوسوم ذات الإغلاق الذاتي لا تحتوي على محتوى داخلي، لذا htmlContents تبقى فارغة
        htmlElement.setHtmlContents(new HtmlContent[0]); // تعيين مصفوفة فارغة

        return htmlElement;
    }



    @Override
    public HtmlStartTag visitHtmlStartTag(AngularParser.HtmlStartTagContext ctx) {
        HtmlStartTag htmlStartTag = new HtmlStartTag();

        if (ctx.tagName() != null) {
            String tagName = ctx.tagName().getText();
            htmlStartTag.setTagName(tagName);

            // ⬅️ تسجيل الوسم الافتتاحي
            Row row = new Row();
            row.setType("startTag");
            row.setValue("Tag: <" + tagName + ">");
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        if (ctx.attribute() != null && !ctx.attribute().isEmpty()) {
            Attribute[] attributes = ctx.attribute()
                    .stream()
                    .map(this::visitHtmlAttribute)
                    .toArray(Attribute[]::new);
            htmlStartTag.setAttributes(attributes);
        }

        return htmlStartTag;
    }


    public Attribute visitHtmlAttribute(AngularParser.AttributeContext ctx) {
        Attribute attribute = new Attribute();
        String name = null;
        String value = null;

        if (ctx instanceof AngularParser.HtmlAttributeBasicContext basicCtx) {
            name = basicCtx.IDENTIFIER().getText();
            value = basicCtx.attributeValue() != null ? basicCtx.attributeValue().getText() : null;
        } else if (ctx instanceof AngularParser.HtmlAttributeBindingContext bindingCtx) {
            name = bindingCtx.BINDING().getText();
            value = bindingCtx.attributeValue() != null ? bindingCtx.attributeValue().getText() : null;
        } else if (ctx instanceof AngularParser.HtmlAttributeStructuralContext structuralCtx) {
            name = structuralCtx.STRUCTURAL_DIRECTIVE().getText();
            value = structuralCtx.attributeValue() != null ? structuralCtx.attributeValue().getText() : null;
        } else if (ctx instanceof AngularParser.HtmlAttributeEventBindingContext eventBindingCtx) {
            name = eventBindingCtx.EVENT_BINDING().getText();
            value = eventBindingCtx.attributeValue() != null ? eventBindingCtx.attributeValue().getText() : null;
        } else if (ctx instanceof AngularParser.HtmlAttributeClassContext classCtx) {
            name = classCtx.CLASS().getText();
            value = classCtx.attributeValue() != null ? classCtx.attributeValue().getText() : null;
        }

        attribute.setName(name);
        attribute.setValue(value);

        // ⬅️ تسجيل السمة في جدول الرموز
        Row row = new Row();
        row.setType("attribute");
        row.setValue(name + (value != null ? (" = " + value) : ""));
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);
        return attribute;
    }



    @Override
    public HtmlEndTag visitHtmlEndTag(AngularParser.HtmlEndTagContext ctx) {
        HtmlEndTag htmlEndTag = new HtmlEndTag();

        if (ctx.tagName() != null) {
            String tagName = ctx.tagName().getText();
            htmlEndTag.setTagName(tagName);

            // ⬅️ تسجيل الوسم الختامي
            Row row = new Row();
            row.setType("endTag");
            row.setValue("Tag: </" + tagName + ">");
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return htmlEndTag;
    }



    @Override
    public HtmlSelfClosingTag visitHtmlSelfClosingTag(AngularParser.HtmlSelfClosingTagContext ctx) {
        HtmlSelfClosingTag htmlSelfClosingTag = new HtmlSelfClosingTag();

        // استخراج اسم الوسم (Tag Name)
        if (ctx.SELF_CLOSE() != null) {
            htmlSelfClosingTag.setTagName(ctx.SELF_CLOSE().getText());
        }

        // معالجة الخصائص (Attributes) إذا وجدت
        if (ctx.attribute() != null && !ctx.attribute().isEmpty()) {
            Attribute[] attributes = ctx.attribute().stream()
                    .map(this::visitHtmlAttribute) // زيارة كل خاصية
                    .toArray(Attribute[]::new);
            htmlSelfClosingTag.setAttributes(attributes);
        }

        return htmlSelfClosingTag;
    }


    @Override
    public Object visitHtmlNestedElement(AngularParser.HtmlNestedElementContext ctx) {
        // ⬅️ تسجيل العنصر المتداخل
        Row row = new Row();
        row.setType("nestedElement");
        row.setValue("Nested Element: " + ctx.getText());
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return visitChildren(ctx);
    }


    @Override
    public Object visitHtmlTextContent(AngularParser.HtmlTextContentContext ctx) {
        String text = ctx.getText().trim();
        if (!text.isEmpty()) {
            // ⬅️ تسجيل المحتوى النصي
            Row row = new Row();
            row.setType("textContent");
            row.setValue("Text: " + text);
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return visitChildren(ctx);
    }


    @Override
    public Object visitHtmlTemplateExpression(AngularParser.HtmlTemplateExpressionContext ctx) {
        String expression = ctx.getText();

        // ⬅️ تسجيل تعبير القالب
        Row row = new Row();
        row.setType("templateExpression");
        row.setValue("Expression: " + expression);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return visitChildren(ctx);
    }


    @Override
    public HtmlTagName visitHtmlTagName(AngularParser.HtmlTagNameContext ctx) {
        HtmlTagName htmlTagName = new HtmlTagName();

        if (ctx.IDENTIFIER() != null) {
            String tagName = ctx.IDENTIFIER().getText();
            htmlTagName.setTagName(tagName);

            // ⬅️ تسجيل اسم الوسم
            Row row = new Row();
            row.setType("tagName");
            row.setValue("Tag Name: " + tagName);
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return htmlTagName;
    }



    @Override
    public HtmlAttributeBasic visitHtmlAttributeBasic(AngularParser.HtmlAttributeBasicContext ctx) {
        HtmlAttributeBasic htmlAttributeBasic = new HtmlAttributeBasic();

        if (ctx.EQUAL() != null) {
            htmlAttributeBasic.setAttributeName(ctx.EQUAL().getText());
        }

        if (ctx.IDENTIFIER() != null) {
            String value = ctx.IDENTIFIER().getText();
            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
                value = value.substring(1, value.length() - 1);
            }
            htmlAttributeBasic.setAttributeValue(value);

            // ⬅️ تسجيل السمة الأساسية
            Row row = new Row();
            row.setType("attributeBasic");
            row.setValue("Basic Attribute: " + htmlAttributeBasic.getAttributeName() + " = " + value);
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return htmlAttributeBasic;
    }



    @Override
    public HtmlAttributeClass visitHtmlAttributeClass(AngularParser.HtmlAttributeClassContext ctx) {
        HtmlAttributeClass htmlAttributeClass = new HtmlAttributeClass();

        if (ctx.CLASS() != null) {
            String value = ctx.CLASS().getText();
            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
                value = value.substring(1, value.length() - 1);
            }

            htmlAttributeClass.setAttributeValue(value);

            // ⬅️ تسجيل الخاصية class
            Row row = new Row();
            row.setType("attributeClass");
            row.setValue("Class Attribute: " + value);
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return htmlAttributeClass;
    }



    @Override
    public HtmlAttributeStructural visitHtmlAttributeStructural(AngularParser.HtmlAttributeStructuralContext ctx) {
        HtmlAttributeStructural htmlAttributeStructural = new HtmlAttributeStructural();

        if (ctx.STRUCTURAL_DIRECTIVE() != null) {
            String value = ctx.STRUCTURAL_DIRECTIVE().getText();
            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
                value = value.substring(1, value.length() - 1);
            }

            htmlAttributeStructural.setAttributeValue(value);

            // ⬅️ تسجيل الخاصية الهيكلية
            Row row = new Row();
            row.setType("attributeStructural");
            row.setValue("Structural Directive: " + value);
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return htmlAttributeStructural;
    }



    @Override
    public HtmlAttributeBinding visitHtmlAttributeBinding(AngularParser.HtmlAttributeBindingContext ctx) {
        HtmlAttributeBinding htmlAttributeBinding = new HtmlAttributeBinding();

        if (ctx.BINDING() != null) {
            String value = ctx.BINDING().getText();

            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
                value = value.substring(1, value.length() - 1);
            }

            htmlAttributeBinding.setAttributeValue(value);

            // إضافة Row إلى جدول الرموز إذا كان binding يحتوي على directive (مثل *ngIf)
            if (ctx.getParent().getText().contains("*")) {
                Row row = new Row();
                row.setType("attributeStructural");
                row.setValue("Structural Directive: " + value);
                row.setLine(ctx.start.getLine());
                row.setColumn(ctx.start.getCharPositionInLine());
                symbolTable.getRows().add(row);
            }
        }

        return htmlAttributeBinding;
    }



    @Override
    public HtmlAttributeEventBinding visitHtmlAttributeEventBinding(AngularParser.HtmlAttributeEventBindingContext ctx) {
        HtmlAttributeEventBinding htmlAttributeEventBinding = new HtmlAttributeEventBinding();

        if (ctx.EVENT_BINDING() != null) {
            String value = ctx.EVENT_BINDING().getText();

            String functionName = value.replaceAll("[()]", "");


//            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
//                value = value.substring(1, value.length() - 1);
//            }

            htmlAttributeEventBinding.setAttributeValue(value);

            // إضافة إلى جدول الرموز
            Row row = new Row();
            row.setType("eventBinding");
            // row.setValue("Event Binding: " + value);
            row.setValue(functionName); // تخزين اسم الدالة فقط

            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return htmlAttributeEventBinding;
    }


    @Override
    public HtmlAttributeValue visitHtmlAttributeValue(AngularParser.HtmlAttributeValueContext ctx) {
        HtmlAttributeValue htmlAttributeValue = new HtmlAttributeValue();

        if (ctx.STRING() != null) {
            String value = ctx.STRING().getText();

            if ((value.startsWith("\"") && value.endsWith("\"")) || (value.startsWith("'") && value.endsWith("'"))) {
                value = value.substring(1, value.length() - 1);
            }

            htmlAttributeValue.setValue(value);

            // إضافة إلى جدول الرموز
            Row row = new Row();
            row.setType("attributeValue");
            row.setValue("Attribute Value: " + value);
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        return htmlAttributeValue;
    }


    @Override
    public TypeScriptClass visitTypeScriptClassDefinition(AngularParser.TypeScriptClassDefinitionContext ctx) {

        TypeScriptClass typeScriptClass = new TypeScriptClass();

        // استخراج اسم الكلاس من السياق
        if (ctx.EXPORT() != null) {
            String className = ctx.EXPORT().getText();
            typeScriptClass.setClassName(className);
        }

        // استخراج جسم الكلاس من السياق
        if (ctx.classBody() != null) {
            ClassBody classBody = visitClassBodyContent((AngularParser.ClassBodyContentContext) ctx.classBody());  // افترض وجود طريقة لزيارة ClassBody
            typeScriptClass.setClassBody(classBody);
        }

        return typeScriptClass;
    }


    @Override
    public ClassBody visitClassBodyContent(AngularParser.ClassBodyContentContext ctx) {
        System.out.println("Visiting class body..."); // Debug line

        ClassBody classBody = new ClassBody();


        // استخراج أعضاء الكلاس من السياق
        List<ClassMember> classMembersList = new ArrayList<>();

        for (AngularParser.ClassMemberContext memberContext : ctx.classMember()) {
            // زيارة كل عضو من أعضاء الكلاس
            ClassMember classMember = new ClassMember(memberContext);  // افترض وجود طريقة لزيارة ClassMember
            classMembersList.add(classMember);
        }
        for (AngularParser.ClassMemberContext memberCtx : ctx.classMember()) {
            // فقط قم بزيارة كل عضو، والزيارات الأخرى (مثل property أو method) ستُستدعى تلقائيًا
            visit(memberCtx);
        }

        // تحويل القائمة إلى مصفوفة وتعيينها
        classBody.setClassMembers(classMembersList.toArray(new ClassMember[0]));

        return classBody;
    }


//    @Override
//    public ClassBody visitClassBodyContent(AngularParser.ClassBodyContentContext ctx) {
//
//        ClassBody classBody = new ClassBody();
//
//        for (AngularParser.ClassMemberContext memberCtx : ctx.classMember()) {
//            // فقط قم بزيارة كل عضو، والزيارات الأخرى (مثل property أو method) ستُستدعى تلقائيًا
//            visit(memberCtx);
//        }
//
//        return classBody;
//    }
//

    @Override
    public Object visitClassProperty(AngularParser.ClassPropertyContext ctx) {
        // معالجة بيانات Class Property
        return visitChildren(ctx);
    }

    @Override
    public Object visitClassMethod(AngularParser.ClassMethodContext ctx) {
        // معالجة بيانات Class Method
        return visitChildren(ctx);
    }

    @Override
//    public PropertyDeclaration visitPropertyDeclarationStatement(AngularParser.PropertyDeclarationStatementContext ctx) {
//        PropertyDeclaration propertyDeclaration = new PropertyDeclaration();
//
//        // استخراج اسم الخاصية (identifier) من السياق
//        String identifier = ctx.IDENTIFIER().getText();
//        propertyDeclaration.setIdentifier(identifier);
//
//        // استخراج قيمة الخاصية (value) من السياق
//        String value = ctx.literal().getText();
//        propertyDeclaration.setValue(value);
//
//        // إضافة إلى جدول الرموز
//        Row row = new Row();
//      //  row.setType("attributeStructural");
//        row.setType("classProperty");
//
//        row.setValue(identifier + " = " + value);
//
//     //   row.setValue("Structural Directive: " + value);
//        row.setLine(ctx.start.getLine());
//        row.setColumn(ctx.start.getCharPositionInLine());
//        symbolTable.getRows().add(row);
//
//        return propertyDeclaration;
//    }
    public PropertyDeclaration visitPropertyDeclarationStatement(AngularParser.PropertyDeclarationStatementContext ctx) {
        PropertyDeclaration propertyDeclaration = new PropertyDeclaration();

        // Extract property name (identifier)
        String identifier = ctx.IDENTIFIER().getText();
        propertyDeclaration.setIdentifier(identifier);

        // Handle value (which may be null)
        String value = null;
        if (ctx.literal() != null) {
            value = ctx.literal().getText();
        }
        propertyDeclaration.setValue(value);

        // Add to symbol table
        Row row = new Row();
        row.setType("classProperty");
        row.setValue(identifier);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);


        ///////////////////////////////////////////
//        // تحديث الجداول المخصصة مباشرة
//        ngForSymbolTable.addComponentVariable(identifier);
//        templateVarSymbolTable.addComponentVariable(identifier);
//        unsafeAccessSymbolTable.addClassProperty(identifier, false); // أو true إذا كان nullable
//        ///////////////////////////////////////////
        return propertyDeclaration;
    }





    @Override
    public MethodDeclaration visitMethodDeclarationDefinition(AngularParser.MethodDeclarationDefinitionContext ctx) {
        MethodDeclaration methodDeclaration = new MethodDeclaration();

        // استخراج اسم الدالة (methodName) من السياق
        String methodName = ctx.IDENTIFIER().getText();
        methodDeclaration.setMethodName(methodName);

        // استخراج قائمة المعاملات (parameterList) من السياق
        ParameterList parameterList = (ParameterList) visitMethodParameterList((AngularParser.MethodParameterListContext) ctx.parameterList());
        methodDeclaration.setParameterList(parameterList);

        // استخراج جسم الدالة (methodBody) من السياق
        MethodBody methodBody = visitMethodBodyContent((AngularParser.MethodBodyContentContext) ctx.methodBody());
        methodDeclaration.setMethodBody(methodBody);

        // إضافة إلى جدول الرموز
        Row row = new Row();
//        row.setType("attributeStructural");
//        row.setValue("Structural Directive: " + methodName);

        row.setType("methodDeclaration");
        row.setValue(methodName);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return methodDeclaration;
    }



    @Override
    public ParameterList visitMethodParameterList(AngularParser.MethodParameterListContext ctx) {
        ParameterList parameterList = new ParameterList();

        // استخراج أسماء المعاملات مباشرة من الـ IDENTIFIER
        List<String> parameterNames = new ArrayList<>();
        for (TerminalNode id : ctx.IDENTIFIER()) {
            parameterNames.add(id.getText());
        }

        parameterList.setParameters(parameterNames.toArray(new String[0]));
        return parameterList;
    }


    @Override
    public MethodBody visitMethodBodyContent(AngularParser.MethodBodyContentContext ctx) {
        MethodBody methodBody = new MethodBody();

        // استخراج البيانات المتعلقة بالـ Statements (البيانات الداخلية للجسم)
        List<Statement> statementsList = new ArrayList<>();

        // استخراج كل بيان داخل الجسم وإضافته إلى القائمة
        for (AngularParser.StatementContext stmtCtx : ctx.statement()) {
            Statement statement = new Statement();

            // معالجة البيان هنا (مثال على استخراج البيانات)
            // يجب أن يتم تحديد كيف يتم استخراج البيانات من البيان.
            String statementText = stmtCtx.getText();  // على سبيل المثال، استخراج النص الخاص بالبيان

            statement.setExpression(statementText);  // تعيين النص في البيان
            statementsList.add(statement);  // إضافة البيان إلى القائمة
        }

        // تحويل القائمة إلى مصفوفة وتعيينها
        methodBody.setStatements(statementsList.toArray(new Statement[0]));

        return methodBody;
    }


    @Override
    public Expression visitExpressionStatement(AngularParser.ExpressionStatementContext ctx) {
        Expression expression = new Expression();

        String identifier = ctx.getText();
        expression.setIdentifier(identifier);
        expression.setValue(identifier);

        Row row = new Row();
        row.setType("attributeStructural");
        row.setValue("Structural Directive: " + identifier);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return expression;
    }



    @Override
    public TestBlock visitBlockStatement(AngularParser.BlockStatementContext ctx) {
        TestBlock testBlock = new TestBlock();
        List<AngularExpression> angularExpressions = new ArrayList<>();

        for (AngularParser.StatementContext stmtCtx : ctx.statement()) {
            if (stmtCtx instanceof AngularParser.ExpressionStatementContext) {
                AngularParser.ExpressionStatementContext exprStmt =
                        (AngularParser.ExpressionStatementContext) stmtCtx;

                AngularParser.ExpressionContext exprCtx = exprStmt.expression();

                AngularExpression angularExpression = new AngularExpression();
                angularExpression.setStringExpression(exprCtx.getText());

                angularExpressions.add(angularExpression);
            }
            // يمكنك معالجة functionCallStatement هنا أيضًا إن أردت
        }

        testBlock.setAngularExpressions(angularExpressions);
        return testBlock;
    }

    @Override
    public FunctionCall visitFunctionCallStatement(AngularParser.FunctionCallStatementContext ctx) {
        FunctionCall functionCall = new FunctionCall();

        AngularParser.FunctionCallDefinitionContext fcCtx = (AngularParser.FunctionCallDefinitionContext) ctx.functionCall();

        // استخراج اسم الدالة
        functionCall.setFunctionName(fcCtx.functionName.getText());

        // إنشاء قائمة الوسائط
        ArgumentList argumentList = new ArgumentList();
        List<Expression> expressions = new ArrayList<>();

        if (fcCtx.args != null) {
            for (AngularParser.ExpressionContext exprCtx : fcCtx.args.expression()) {
                Expression expr = new Expression();
                expr.setValue(exprCtx.getText());
                expressions.add(expr);
            }
        }

        argumentList.setExpressions(expressions.toArray(new Expression[0]));
        functionCall.setArgumentList(argumentList);

        return functionCall;
    }

    @Override
    public Object visitAssignmentExpression(AngularParser.AssignmentExpressionContext ctx) {
        // معالجة بيانات Assignment Expression
        return visitChildren(ctx);
    }

    @Override
    public Object visitIdentifierExpression(AngularParser.IdentifierExpressionContext ctx) {
        // معالجة بيانات Identifier Expression
        return visitChildren(ctx);
    }




    @Override
    public Object visitStringExpression(AngularParser.StringExpressionContext ctx) {
        // معالجة بيانات String Expression
        return visitChildren(ctx);
    }

    @Override
    public Object visitNumberExpression(AngularParser.NumberExpressionContext ctx) {
        // معالجة بيانات Number Expression
        return visitChildren(ctx);
    }

    @Override
    public Object visitThisAssignmentExpression(AngularParser.ThisAssignmentExpressionContext ctx) {
        // معالجة بيانات This Assignment Expression
        return visitChildren(ctx);
    }

    @Override
    public Object visitFunctionCallDefinition(AngularParser.FunctionCallDefinitionContext ctx) {
        // معالجة بيانات Function Call Definition
        return visitChildren(ctx);
    }

    @Override
    public TestBlock visitTestBlock(AngularParser.TestBlockContext ctx) {
        TestBlock testBlock = new TestBlock();
        List<AngularExpression> angularExpressions = new ArrayList<>();

        for (AngularParser.AngularExpressionContext exprCtx : ctx.angularExpression()) {
            AngularExpression angularExpression = new AngularExpression();
            String expressionValue = exprCtx.getText();
            angularExpression.setStringExpression(expressionValue);
            angularExpressions.add(angularExpression);

            Row row = new Row();
            row.setType("attributeStructural");
            row.setValue("Structural Directive: " + expressionValue);
            row.setLine(ctx.start.getLine());
            row.setColumn(ctx.start.getCharPositionInLine());
            symbolTable.getRows().add(row);
        }

        testBlock.setAngularExpressions(angularExpressions);
        return testBlock;
    }



    @Override
    public NullLiteral visitNullLiteral(AngularParser.NullLiteralContext ctx) {
        // إنشاء كائن NullLiteral
        NullLiteral nullLiteral = new NullLiteral();

        // لا توجد معالجة إضافية لأنه لا يوجد بيانات أخرى في NullLiteral

        // إرجاع الكائن NullLiteral
        return nullLiteral;
    }


    @Override
    public StringLiteral visitStringLiteral(AngularParser.StringLiteralContext ctx) {
        StringLiteral stringLiteral = new StringLiteral();
        String value = ctx.getText();
        stringLiteral.setValue(value);

        Row row = new Row();
        row.setType("attributeStructural");
        row.setValue("Structural Directive: " + value);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return stringLiteral;
    }



    @Override
    public NumberLiteral visitNumberLiteral(AngularParser.NumberLiteralContext ctx) {
        NumberLiteral numberLiteral = new NumberLiteral();
        String valueText = ctx.getText();
        double value = Double.parseDouble(valueText);
        numberLiteral.setValue(value);

        Row row = new Row();
        row.setType("attributeStructural");
        row.setValue("Structural Directive: " + valueText);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return numberLiteral;
    }



    @Override
    public AngularIdentifierExpression visitAngularIdentifierExpression(AngularParser.AngularIdentifierExpressionContext ctx) {
        AngularIdentifierExpression angularIdentifierExpression = new AngularIdentifierExpression();
        String identifier = ctx.getText();
        angularIdentifierExpression.setIdentifier(identifier);

        Row row = new Row();
        row.setType("attributeStructural");
        row.setValue("Structural Directive: " + identifier);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return angularIdentifierExpression;
    }



    @Override
    public AngularStringExpression visitAngularStringExpression(AngularParser.AngularStringExpressionContext ctx) {
        AngularStringExpression angularStringExpression = new AngularStringExpression();

        // استخراج قيمة السلسلة النصية من ctx
        String value = ctx.getText();
        angularStringExpression.setValue(value);

        // تسجيل البيان في جدول الرموز
        Row row = new Row();
        row.setType("attributeStructural");
        row.setValue("Structural Directive: " + value);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return angularStringExpression;
    }



    @Override
    public AngularTemplateExpression visitAngularTemplateExpression(AngularParser.AngularTemplateExpressionContext ctx) {
        AngularTemplateExpression angularTemplateExpression = new AngularTemplateExpression();

        // استخراج القالب النصي من ctx
        String template = ctx.getText();
        angularTemplateExpression.setTemplate(template);

        // تسجيل البيان في جدول الرموز
        Row row = new Row();
        row.setType("attributeStructural");
        row.setValue("Structural Directive: " + template);
        row.setLine(ctx.start.getLine());
        row.setColumn(ctx.start.getCharPositionInLine());
        symbolTable.getRows().add(row);

        return angularTemplateExpression;
    }



}

