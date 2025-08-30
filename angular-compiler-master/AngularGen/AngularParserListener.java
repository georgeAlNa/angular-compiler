// Generated from C:/Users/SCC-M/Desktop/New folder/compiler-2.2/AngularParser.g4 by ANTLR 4.13.1
package AngularGen;
import org.antlr.v4.runtime.tree.ParseTreeListener;

/**
 * This interface defines a complete listener for a parse tree produced by
 * {@link AngularParser}.
 */
public interface AngularParserListener extends ParseTreeListener {
	/**
	 * Enter a parse tree produced by the {@code applicationRoot}
	 * labeled alternative in {@link AngularParser#application}.
	 * @param ctx the parse tree
	 */
	void enterApplicationRoot(AngularParser.ApplicationRootContext ctx);
	/**
	 * Exit a parse tree produced by the {@code applicationRoot}
	 * labeled alternative in {@link AngularParser#application}.
	 * @param ctx the parse tree
	 */
	void exitApplicationRoot(AngularParser.ApplicationRootContext ctx);
	/**
	 * Enter a parse tree produced by the {@code importStatementDefinition}
	 * labeled alternative in {@link AngularParser#importStatement}.
	 * @param ctx the parse tree
	 */
	void enterImportStatementDefinition(AngularParser.ImportStatementDefinitionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code importStatementDefinition}
	 * labeled alternative in {@link AngularParser#importStatement}.
	 * @param ctx the parse tree
	 */
	void exitImportStatementDefinition(AngularParser.ImportStatementDefinitionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code componentDefinition}
	 * labeled alternative in {@link AngularParser#component}.
	 * @param ctx the parse tree
	 */
	void enterComponentDefinition(AngularParser.ComponentDefinitionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code componentDefinition}
	 * labeled alternative in {@link AngularParser#component}.
	 * @param ctx the parse tree
	 */
	void exitComponentDefinition(AngularParser.ComponentDefinitionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code componentMetadataDefinition}
	 * labeled alternative in {@link AngularParser#componentMetadata}.
	 * @param ctx the parse tree
	 */
	void enterComponentMetadataDefinition(AngularParser.ComponentMetadataDefinitionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code componentMetadataDefinition}
	 * labeled alternative in {@link AngularParser#componentMetadata}.
	 * @param ctx the parse tree
	 */
	void exitComponentMetadataDefinition(AngularParser.ComponentMetadataDefinitionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code metadataSelector}
	 * labeled alternative in {@link AngularParser#metadataEntry}.
	 * @param ctx the parse tree
	 */
	void enterMetadataSelector(AngularParser.MetadataSelectorContext ctx);
	/**
	 * Exit a parse tree produced by the {@code metadataSelector}
	 * labeled alternative in {@link AngularParser#metadataEntry}.
	 * @param ctx the parse tree
	 */
	void exitMetadataSelector(AngularParser.MetadataSelectorContext ctx);
	/**
	 * Enter a parse tree produced by the {@code metadataTemplate}
	 * labeled alternative in {@link AngularParser#metadataEntry}.
	 * @param ctx the parse tree
	 */
	void enterMetadataTemplate(AngularParser.MetadataTemplateContext ctx);
	/**
	 * Exit a parse tree produced by the {@code metadataTemplate}
	 * labeled alternative in {@link AngularParser#metadataEntry}.
	 * @param ctx the parse tree
	 */
	void exitMetadataTemplate(AngularParser.MetadataTemplateContext ctx);
	/**
	 * Enter a parse tree produced by the {@code metadataStyles}
	 * labeled alternative in {@link AngularParser#metadataEntry}.
	 * @param ctx the parse tree
	 */
	void enterMetadataStyles(AngularParser.MetadataStylesContext ctx);
	/**
	 * Exit a parse tree produced by the {@code metadataStyles}
	 * labeled alternative in {@link AngularParser#metadataEntry}.
	 * @param ctx the parse tree
	 */
	void exitMetadataStyles(AngularParser.MetadataStylesContext ctx);
	/**
	 * Enter a parse tree produced by the {@code stylesContentBlock}
	 * labeled alternative in {@link AngularParser#stylesContent}.
	 * @param ctx the parse tree
	 */
	void enterStylesContentBlock(AngularParser.StylesContentBlockContext ctx);
	/**
	 * Exit a parse tree produced by the {@code stylesContentBlock}
	 * labeled alternative in {@link AngularParser#stylesContent}.
	 * @param ctx the parse tree
	 */
	void exitStylesContentBlock(AngularParser.StylesContentBlockContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cssContentRules}
	 * labeled alternative in {@link AngularParser#cssContent}.
	 * @param ctx the parse tree
	 */
	void enterCssContentRules(AngularParser.CssContentRulesContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cssContentRules}
	 * labeled alternative in {@link AngularParser#cssContent}.
	 * @param ctx the parse tree
	 */
	void exitCssContentRules(AngularParser.CssContentRulesContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cssRuleDefinition}
	 * labeled alternative in {@link AngularParser#cssRule}.
	 * @param ctx the parse tree
	 */
	void enterCssRuleDefinition(AngularParser.CssRuleDefinitionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cssRuleDefinition}
	 * labeled alternative in {@link AngularParser#cssRule}.
	 * @param ctx the parse tree
	 */
	void exitCssRuleDefinition(AngularParser.CssRuleDefinitionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cssDeclarationEntry}
	 * labeled alternative in {@link AngularParser#cssDeclaration}.
	 * @param ctx the parse tree
	 */
	void enterCssDeclarationEntry(AngularParser.CssDeclarationEntryContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cssDeclarationEntry}
	 * labeled alternative in {@link AngularParser#cssDeclaration}.
	 * @param ctx the parse tree
	 */
	void exitCssDeclarationEntry(AngularParser.CssDeclarationEntryContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cssValuePercentage}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void enterCssValuePercentage(AngularParser.CssValuePercentageContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cssValuePercentage}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void exitCssValuePercentage(AngularParser.CssValuePercentageContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cssValueFunction}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void enterCssValueFunction(AngularParser.CssValueFunctionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cssValueFunction}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void exitCssValueFunction(AngularParser.CssValueFunctionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cssValueColor}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void enterCssValueColor(AngularParser.CssValueColorContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cssValueColor}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void exitCssValueColor(AngularParser.CssValueColorContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cssValueString}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void enterCssValueString(AngularParser.CssValueStringContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cssValueString}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void exitCssValueString(AngularParser.CssValueStringContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cssValueNumber}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void enterCssValueNumber(AngularParser.CssValueNumberContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cssValueNumber}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void exitCssValueNumber(AngularParser.CssValueNumberContext ctx);
	/**
	 * Enter a parse tree produced by the {@code cssValueAlphabet}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void enterCssValueAlphabet(AngularParser.CssValueAlphabetContext ctx);
	/**
	 * Exit a parse tree produced by the {@code cssValueAlphabet}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 */
	void exitCssValueAlphabet(AngularParser.CssValueAlphabetContext ctx);
	/**
	 * Enter a parse tree produced by the {@code inlineTemplateDefinition}
	 * labeled alternative in {@link AngularParser#inlineTemplate}.
	 * @param ctx the parse tree
	 */
	void enterInlineTemplateDefinition(AngularParser.InlineTemplateDefinitionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code inlineTemplateDefinition}
	 * labeled alternative in {@link AngularParser#inlineTemplate}.
	 * @param ctx the parse tree
	 */
	void exitInlineTemplateDefinition(AngularParser.InlineTemplateDefinitionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlDocumentContent}
	 * labeled alternative in {@link AngularParser#htmlDocument}.
	 * @param ctx the parse tree
	 */
	void enterHtmlDocumentContent(AngularParser.HtmlDocumentContentContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlDocumentContent}
	 * labeled alternative in {@link AngularParser#htmlDocument}.
	 * @param ctx the parse tree
	 */
	void exitHtmlDocumentContent(AngularParser.HtmlDocumentContentContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlStandardElement}
	 * labeled alternative in {@link AngularParser#htmlElement}.
	 * @param ctx the parse tree
	 */
	void enterHtmlStandardElement(AngularParser.HtmlStandardElementContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlStandardElement}
	 * labeled alternative in {@link AngularParser#htmlElement}.
	 * @param ctx the parse tree
	 */
	void exitHtmlStandardElement(AngularParser.HtmlStandardElementContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlSelfClosingElement}
	 * labeled alternative in {@link AngularParser#htmlElement}.
	 * @param ctx the parse tree
	 */
	void enterHtmlSelfClosingElement(AngularParser.HtmlSelfClosingElementContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlSelfClosingElement}
	 * labeled alternative in {@link AngularParser#htmlElement}.
	 * @param ctx the parse tree
	 */
	void exitHtmlSelfClosingElement(AngularParser.HtmlSelfClosingElementContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlStartTag}
	 * labeled alternative in {@link AngularParser#startTag}.
	 * @param ctx the parse tree
	 */
	void enterHtmlStartTag(AngularParser.HtmlStartTagContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlStartTag}
	 * labeled alternative in {@link AngularParser#startTag}.
	 * @param ctx the parse tree
	 */
	void exitHtmlStartTag(AngularParser.HtmlStartTagContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlEndTag}
	 * labeled alternative in {@link AngularParser#endTag}.
	 * @param ctx the parse tree
	 */
	void enterHtmlEndTag(AngularParser.HtmlEndTagContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlEndTag}
	 * labeled alternative in {@link AngularParser#endTag}.
	 * @param ctx the parse tree
	 */
	void exitHtmlEndTag(AngularParser.HtmlEndTagContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlSelfClosingTag}
	 * labeled alternative in {@link AngularParser#selfClosingTag}.
	 * @param ctx the parse tree
	 */
	void enterHtmlSelfClosingTag(AngularParser.HtmlSelfClosingTagContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlSelfClosingTag}
	 * labeled alternative in {@link AngularParser#selfClosingTag}.
	 * @param ctx the parse tree
	 */
	void exitHtmlSelfClosingTag(AngularParser.HtmlSelfClosingTagContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlNestedElement}
	 * labeled alternative in {@link AngularParser#htmlContent}.
	 * @param ctx the parse tree
	 */
	void enterHtmlNestedElement(AngularParser.HtmlNestedElementContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlNestedElement}
	 * labeled alternative in {@link AngularParser#htmlContent}.
	 * @param ctx the parse tree
	 */
	void exitHtmlNestedElement(AngularParser.HtmlNestedElementContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlTextContent}
	 * labeled alternative in {@link AngularParser#htmlContent}.
	 * @param ctx the parse tree
	 */
	void enterHtmlTextContent(AngularParser.HtmlTextContentContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlTextContent}
	 * labeled alternative in {@link AngularParser#htmlContent}.
	 * @param ctx the parse tree
	 */
	void exitHtmlTextContent(AngularParser.HtmlTextContentContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlTemplateExpression}
	 * labeled alternative in {@link AngularParser#htmlContent}.
	 * @param ctx the parse tree
	 */
	void enterHtmlTemplateExpression(AngularParser.HtmlTemplateExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlTemplateExpression}
	 * labeled alternative in {@link AngularParser#htmlContent}.
	 * @param ctx the parse tree
	 */
	void exitHtmlTemplateExpression(AngularParser.HtmlTemplateExpressionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlTagName}
	 * labeled alternative in {@link AngularParser#tagName}.
	 * @param ctx the parse tree
	 */
	void enterHtmlTagName(AngularParser.HtmlTagNameContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlTagName}
	 * labeled alternative in {@link AngularParser#tagName}.
	 * @param ctx the parse tree
	 */
	void exitHtmlTagName(AngularParser.HtmlTagNameContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlAttributeBasic}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void enterHtmlAttributeBasic(AngularParser.HtmlAttributeBasicContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlAttributeBasic}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void exitHtmlAttributeBasic(AngularParser.HtmlAttributeBasicContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlAttributeClass}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void enterHtmlAttributeClass(AngularParser.HtmlAttributeClassContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlAttributeClass}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void exitHtmlAttributeClass(AngularParser.HtmlAttributeClassContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlAttributeStructural}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void enterHtmlAttributeStructural(AngularParser.HtmlAttributeStructuralContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlAttributeStructural}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void exitHtmlAttributeStructural(AngularParser.HtmlAttributeStructuralContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlAttributeBinding}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void enterHtmlAttributeBinding(AngularParser.HtmlAttributeBindingContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlAttributeBinding}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void exitHtmlAttributeBinding(AngularParser.HtmlAttributeBindingContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlAttributeEventBinding}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void enterHtmlAttributeEventBinding(AngularParser.HtmlAttributeEventBindingContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlAttributeEventBinding}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 */
	void exitHtmlAttributeEventBinding(AngularParser.HtmlAttributeEventBindingContext ctx);
	/**
	 * Enter a parse tree produced by the {@code htmlAttributeValue}
	 * labeled alternative in {@link AngularParser#attributeValue}.
	 * @param ctx the parse tree
	 */
	void enterHtmlAttributeValue(AngularParser.HtmlAttributeValueContext ctx);
	/**
	 * Exit a parse tree produced by the {@code htmlAttributeValue}
	 * labeled alternative in {@link AngularParser#attributeValue}.
	 * @param ctx the parse tree
	 */
	void exitHtmlAttributeValue(AngularParser.HtmlAttributeValueContext ctx);
	/**
	 * Enter a parse tree produced by the {@code typeScriptClassDefinition}
	 * labeled alternative in {@link AngularParser#typeScriptClass}.
	 * @param ctx the parse tree
	 */
	void enterTypeScriptClassDefinition(AngularParser.TypeScriptClassDefinitionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code typeScriptClassDefinition}
	 * labeled alternative in {@link AngularParser#typeScriptClass}.
	 * @param ctx the parse tree
	 */
	void exitTypeScriptClassDefinition(AngularParser.TypeScriptClassDefinitionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code classBodyContent}
	 * labeled alternative in {@link AngularParser#classBody}.
	 * @param ctx the parse tree
	 */
	void enterClassBodyContent(AngularParser.ClassBodyContentContext ctx);
	/**
	 * Exit a parse tree produced by the {@code classBodyContent}
	 * labeled alternative in {@link AngularParser#classBody}.
	 * @param ctx the parse tree
	 */
	void exitClassBodyContent(AngularParser.ClassBodyContentContext ctx);
	/**
	 * Enter a parse tree produced by the {@code classProperty}
	 * labeled alternative in {@link AngularParser#classMember}.
	 * @param ctx the parse tree
	 */
	void enterClassProperty(AngularParser.ClassPropertyContext ctx);
	/**
	 * Exit a parse tree produced by the {@code classProperty}
	 * labeled alternative in {@link AngularParser#classMember}.
	 * @param ctx the parse tree
	 */
	void exitClassProperty(AngularParser.ClassPropertyContext ctx);
	/**
	 * Enter a parse tree produced by the {@code classMethod}
	 * labeled alternative in {@link AngularParser#classMember}.
	 * @param ctx the parse tree
	 */
	void enterClassMethod(AngularParser.ClassMethodContext ctx);
	/**
	 * Exit a parse tree produced by the {@code classMethod}
	 * labeled alternative in {@link AngularParser#classMember}.
	 * @param ctx the parse tree
	 */
	void exitClassMethod(AngularParser.ClassMethodContext ctx);
	/**
	 * Enter a parse tree produced by the {@code propertyDeclarationStatement}
	 * labeled alternative in {@link AngularParser#propertyDeclaration}.
	 * @param ctx the parse tree
	 */
	void enterPropertyDeclarationStatement(AngularParser.PropertyDeclarationStatementContext ctx);
	/**
	 * Exit a parse tree produced by the {@code propertyDeclarationStatement}
	 * labeled alternative in {@link AngularParser#propertyDeclaration}.
	 * @param ctx the parse tree
	 */
	void exitPropertyDeclarationStatement(AngularParser.PropertyDeclarationStatementContext ctx);
	/**
	 * Enter a parse tree produced by the {@code methodDeclarationDefinition}
	 * labeled alternative in {@link AngularParser#methodDeclaration}.
	 * @param ctx the parse tree
	 */
	void enterMethodDeclarationDefinition(AngularParser.MethodDeclarationDefinitionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code methodDeclarationDefinition}
	 * labeled alternative in {@link AngularParser#methodDeclaration}.
	 * @param ctx the parse tree
	 */
	void exitMethodDeclarationDefinition(AngularParser.MethodDeclarationDefinitionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code methodParameterList}
	 * labeled alternative in {@link AngularParser#parameterList}.
	 * @param ctx the parse tree
	 */
	void enterMethodParameterList(AngularParser.MethodParameterListContext ctx);
	/**
	 * Exit a parse tree produced by the {@code methodParameterList}
	 * labeled alternative in {@link AngularParser#parameterList}.
	 * @param ctx the parse tree
	 */
	void exitMethodParameterList(AngularParser.MethodParameterListContext ctx);
	/**
	 * Enter a parse tree produced by the {@code methodBodyContent}
	 * labeled alternative in {@link AngularParser#methodBody}.
	 * @param ctx the parse tree
	 */
	void enterMethodBodyContent(AngularParser.MethodBodyContentContext ctx);
	/**
	 * Exit a parse tree produced by the {@code methodBodyContent}
	 * labeled alternative in {@link AngularParser#methodBody}.
	 * @param ctx the parse tree
	 */
	void exitMethodBodyContent(AngularParser.MethodBodyContentContext ctx);
	/**
	 * Enter a parse tree produced by the {@code expressionStatement}
	 * labeled alternative in {@link AngularParser#statement}.
	 * @param ctx the parse tree
	 */
	void enterExpressionStatement(AngularParser.ExpressionStatementContext ctx);
	/**
	 * Exit a parse tree produced by the {@code expressionStatement}
	 * labeled alternative in {@link AngularParser#statement}.
	 * @param ctx the parse tree
	 */
	void exitExpressionStatement(AngularParser.ExpressionStatementContext ctx);
	/**
	 * Enter a parse tree produced by the {@code blockStatement}
	 * labeled alternative in {@link AngularParser#statement}.
	 * @param ctx the parse tree
	 */
	void enterBlockStatement(AngularParser.BlockStatementContext ctx);
	/**
	 * Exit a parse tree produced by the {@code blockStatement}
	 * labeled alternative in {@link AngularParser#statement}.
	 * @param ctx the parse tree
	 */
	void exitBlockStatement(AngularParser.BlockStatementContext ctx);
	/**
	 * Enter a parse tree produced by the {@code functionCallStatement}
	 * labeled alternative in {@link AngularParser#statement}.
	 * @param ctx the parse tree
	 */
	void enterFunctionCallStatement(AngularParser.FunctionCallStatementContext ctx);
	/**
	 * Exit a parse tree produced by the {@code functionCallStatement}
	 * labeled alternative in {@link AngularParser#statement}.
	 * @param ctx the parse tree
	 */
	void exitFunctionCallStatement(AngularParser.FunctionCallStatementContext ctx);
	/**
	 * Enter a parse tree produced by the {@code assignmentExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void enterAssignmentExpression(AngularParser.AssignmentExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code assignmentExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void exitAssignmentExpression(AngularParser.AssignmentExpressionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code identifierExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void enterIdentifierExpression(AngularParser.IdentifierExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code identifierExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void exitIdentifierExpression(AngularParser.IdentifierExpressionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code functionCallExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void enterFunctionCallExpression(AngularParser.FunctionCallExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code functionCallExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void exitFunctionCallExpression(AngularParser.FunctionCallExpressionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code stringExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void enterStringExpression(AngularParser.StringExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code stringExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void exitStringExpression(AngularParser.StringExpressionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code numberExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void enterNumberExpression(AngularParser.NumberExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code numberExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void exitNumberExpression(AngularParser.NumberExpressionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code thisAssignmentExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void enterThisAssignmentExpression(AngularParser.ThisAssignmentExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code thisAssignmentExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 */
	void exitThisAssignmentExpression(AngularParser.ThisAssignmentExpressionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code functionCallDefinition}
	 * labeled alternative in {@link AngularParser#functionCall}.
	 * @param ctx the parse tree
	 */
	void enterFunctionCallDefinition(AngularParser.FunctionCallDefinitionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code functionCallDefinition}
	 * labeled alternative in {@link AngularParser#functionCall}.
	 * @param ctx the parse tree
	 */
	void exitFunctionCallDefinition(AngularParser.FunctionCallDefinitionContext ctx);
	/**
	 * Enter a parse tree produced by {@link AngularParser#argumentList}.
	 * @param ctx the parse tree
	 */
	void enterArgumentList(AngularParser.ArgumentListContext ctx);
	/**
	 * Exit a parse tree produced by {@link AngularParser#argumentList}.
	 * @param ctx the parse tree
	 */
	void exitArgumentList(AngularParser.ArgumentListContext ctx);
	/**
	 * Enter a parse tree produced by the {@code testBlock}
	 * labeled alternative in {@link AngularParser#test}.
	 * @param ctx the parse tree
	 */
	void enterTestBlock(AngularParser.TestBlockContext ctx);
	/**
	 * Exit a parse tree produced by the {@code testBlock}
	 * labeled alternative in {@link AngularParser#test}.
	 * @param ctx the parse tree
	 */
	void exitTestBlock(AngularParser.TestBlockContext ctx);
	/**
	 * Enter a parse tree produced by the {@code nullLiteral}
	 * labeled alternative in {@link AngularParser#literal}.
	 * @param ctx the parse tree
	 */
	void enterNullLiteral(AngularParser.NullLiteralContext ctx);
	/**
	 * Exit a parse tree produced by the {@code nullLiteral}
	 * labeled alternative in {@link AngularParser#literal}.
	 * @param ctx the parse tree
	 */
	void exitNullLiteral(AngularParser.NullLiteralContext ctx);
	/**
	 * Enter a parse tree produced by the {@code stringLiteral}
	 * labeled alternative in {@link AngularParser#literal}.
	 * @param ctx the parse tree
	 */
	void enterStringLiteral(AngularParser.StringLiteralContext ctx);
	/**
	 * Exit a parse tree produced by the {@code stringLiteral}
	 * labeled alternative in {@link AngularParser#literal}.
	 * @param ctx the parse tree
	 */
	void exitStringLiteral(AngularParser.StringLiteralContext ctx);
	/**
	 * Enter a parse tree produced by the {@code numberLiteral}
	 * labeled alternative in {@link AngularParser#literal}.
	 * @param ctx the parse tree
	 */
	void enterNumberLiteral(AngularParser.NumberLiteralContext ctx);
	/**
	 * Exit a parse tree produced by the {@code numberLiteral}
	 * labeled alternative in {@link AngularParser#literal}.
	 * @param ctx the parse tree
	 */
	void exitNumberLiteral(AngularParser.NumberLiteralContext ctx);
	/**
	 * Enter a parse tree produced by the {@code angularIdentifierExpression}
	 * labeled alternative in {@link AngularParser#angularExpression}.
	 * @param ctx the parse tree
	 */
	void enterAngularIdentifierExpression(AngularParser.AngularIdentifierExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code angularIdentifierExpression}
	 * labeled alternative in {@link AngularParser#angularExpression}.
	 * @param ctx the parse tree
	 */
	void exitAngularIdentifierExpression(AngularParser.AngularIdentifierExpressionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code angularStringExpression}
	 * labeled alternative in {@link AngularParser#angularExpression}.
	 * @param ctx the parse tree
	 */
	void enterAngularStringExpression(AngularParser.AngularStringExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code angularStringExpression}
	 * labeled alternative in {@link AngularParser#angularExpression}.
	 * @param ctx the parse tree
	 */
	void exitAngularStringExpression(AngularParser.AngularStringExpressionContext ctx);
	/**
	 * Enter a parse tree produced by the {@code angularTemplateExpression}
	 * labeled alternative in {@link AngularParser#angularExpression}.
	 * @param ctx the parse tree
	 */
	void enterAngularTemplateExpression(AngularParser.AngularTemplateExpressionContext ctx);
	/**
	 * Exit a parse tree produced by the {@code angularTemplateExpression}
	 * labeled alternative in {@link AngularParser#angularExpression}.
	 * @param ctx the parse tree
	 */
	void exitAngularTemplateExpression(AngularParser.AngularTemplateExpressionContext ctx);
}