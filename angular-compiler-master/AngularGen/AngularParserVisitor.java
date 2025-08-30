// Generated from C:/Users/SCC-M/Desktop/New folder/compiler-2.2/AngularParser.g4 by ANTLR 4.13.1
package AngularGen;
import org.antlr.v4.runtime.tree.ParseTreeVisitor;

/**
 * This interface defines a complete generic visitor for a parse tree produced
 * by {@link AngularParser}.
 *
 * @param <T> The return type of the visit operation. Use {@link Void} for
 * operations with no return type.
 */
public interface AngularParserVisitor<T> extends ParseTreeVisitor<T> {
	/**
	 * Visit a parse tree produced by the {@code applicationRoot}
	 * labeled alternative in {@link AngularParser#application}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitApplicationRoot(AngularParser.ApplicationRootContext ctx);
	/**
	 * Visit a parse tree produced by the {@code importStatementDefinition}
	 * labeled alternative in {@link AngularParser#importStatement}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitImportStatementDefinition(AngularParser.ImportStatementDefinitionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code componentDefinition}
	 * labeled alternative in {@link AngularParser#component}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitComponentDefinition(AngularParser.ComponentDefinitionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code componentMetadataDefinition}
	 * labeled alternative in {@link AngularParser#componentMetadata}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitComponentMetadataDefinition(AngularParser.ComponentMetadataDefinitionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code metadataSelector}
	 * labeled alternative in {@link AngularParser#metadataEntry}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitMetadataSelector(AngularParser.MetadataSelectorContext ctx);
	/**
	 * Visit a parse tree produced by the {@code metadataTemplate}
	 * labeled alternative in {@link AngularParser#metadataEntry}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitMetadataTemplate(AngularParser.MetadataTemplateContext ctx);
	/**
	 * Visit a parse tree produced by the {@code metadataStyles}
	 * labeled alternative in {@link AngularParser#metadataEntry}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitMetadataStyles(AngularParser.MetadataStylesContext ctx);
	/**
	 * Visit a parse tree produced by the {@code stylesContentBlock}
	 * labeled alternative in {@link AngularParser#stylesContent}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitStylesContentBlock(AngularParser.StylesContentBlockContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cssContentRules}
	 * labeled alternative in {@link AngularParser#cssContent}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCssContentRules(AngularParser.CssContentRulesContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cssRuleDefinition}
	 * labeled alternative in {@link AngularParser#cssRule}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCssRuleDefinition(AngularParser.CssRuleDefinitionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cssDeclarationEntry}
	 * labeled alternative in {@link AngularParser#cssDeclaration}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCssDeclarationEntry(AngularParser.CssDeclarationEntryContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cssValuePercentage}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCssValuePercentage(AngularParser.CssValuePercentageContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cssValueFunction}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCssValueFunction(AngularParser.CssValueFunctionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cssValueColor}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCssValueColor(AngularParser.CssValueColorContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cssValueString}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCssValueString(AngularParser.CssValueStringContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cssValueNumber}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCssValueNumber(AngularParser.CssValueNumberContext ctx);
	/**
	 * Visit a parse tree produced by the {@code cssValueAlphabet}
	 * labeled alternative in {@link AngularParser#cssValue}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitCssValueAlphabet(AngularParser.CssValueAlphabetContext ctx);
	/**
	 * Visit a parse tree produced by the {@code inlineTemplateDefinition}
	 * labeled alternative in {@link AngularParser#inlineTemplate}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitInlineTemplateDefinition(AngularParser.InlineTemplateDefinitionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlDocumentContent}
	 * labeled alternative in {@link AngularParser#htmlDocument}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlDocumentContent(AngularParser.HtmlDocumentContentContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlStandardElement}
	 * labeled alternative in {@link AngularParser#htmlElement}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlStandardElement(AngularParser.HtmlStandardElementContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlSelfClosingElement}
	 * labeled alternative in {@link AngularParser#htmlElement}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlSelfClosingElement(AngularParser.HtmlSelfClosingElementContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlStartTag}
	 * labeled alternative in {@link AngularParser#startTag}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlStartTag(AngularParser.HtmlStartTagContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlEndTag}
	 * labeled alternative in {@link AngularParser#endTag}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlEndTag(AngularParser.HtmlEndTagContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlSelfClosingTag}
	 * labeled alternative in {@link AngularParser#selfClosingTag}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlSelfClosingTag(AngularParser.HtmlSelfClosingTagContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlNestedElement}
	 * labeled alternative in {@link AngularParser#htmlContent}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlNestedElement(AngularParser.HtmlNestedElementContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlTextContent}
	 * labeled alternative in {@link AngularParser#htmlContent}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlTextContent(AngularParser.HtmlTextContentContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlTemplateExpression}
	 * labeled alternative in {@link AngularParser#htmlContent}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlTemplateExpression(AngularParser.HtmlTemplateExpressionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlTagName}
	 * labeled alternative in {@link AngularParser#tagName}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlTagName(AngularParser.HtmlTagNameContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlAttributeBasic}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlAttributeBasic(AngularParser.HtmlAttributeBasicContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlAttributeClass}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlAttributeClass(AngularParser.HtmlAttributeClassContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlAttributeStructural}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlAttributeStructural(AngularParser.HtmlAttributeStructuralContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlAttributeBinding}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlAttributeBinding(AngularParser.HtmlAttributeBindingContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlAttributeEventBinding}
	 * labeled alternative in {@link AngularParser#attribute}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlAttributeEventBinding(AngularParser.HtmlAttributeEventBindingContext ctx);
	/**
	 * Visit a parse tree produced by the {@code htmlAttributeValue}
	 * labeled alternative in {@link AngularParser#attributeValue}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitHtmlAttributeValue(AngularParser.HtmlAttributeValueContext ctx);
	/**
	 * Visit a parse tree produced by the {@code typeScriptClassDefinition}
	 * labeled alternative in {@link AngularParser#typeScriptClass}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitTypeScriptClassDefinition(AngularParser.TypeScriptClassDefinitionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code classBodyContent}
	 * labeled alternative in {@link AngularParser#classBody}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitClassBodyContent(AngularParser.ClassBodyContentContext ctx);
	/**
	 * Visit a parse tree produced by the {@code classProperty}
	 * labeled alternative in {@link AngularParser#classMember}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitClassProperty(AngularParser.ClassPropertyContext ctx);
	/**
	 * Visit a parse tree produced by the {@code classMethod}
	 * labeled alternative in {@link AngularParser#classMember}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitClassMethod(AngularParser.ClassMethodContext ctx);
	/**
	 * Visit a parse tree produced by the {@code propertyDeclarationStatement}
	 * labeled alternative in {@link AngularParser#propertyDeclaration}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitPropertyDeclarationStatement(AngularParser.PropertyDeclarationStatementContext ctx);
	/**
	 * Visit a parse tree produced by the {@code methodDeclarationDefinition}
	 * labeled alternative in {@link AngularParser#methodDeclaration}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitMethodDeclarationDefinition(AngularParser.MethodDeclarationDefinitionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code methodParameterList}
	 * labeled alternative in {@link AngularParser#parameterList}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitMethodParameterList(AngularParser.MethodParameterListContext ctx);
	/**
	 * Visit a parse tree produced by the {@code methodBodyContent}
	 * labeled alternative in {@link AngularParser#methodBody}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitMethodBodyContent(AngularParser.MethodBodyContentContext ctx);
	/**
	 * Visit a parse tree produced by the {@code expressionStatement}
	 * labeled alternative in {@link AngularParser#statement}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitExpressionStatement(AngularParser.ExpressionStatementContext ctx);
	/**
	 * Visit a parse tree produced by the {@code blockStatement}
	 * labeled alternative in {@link AngularParser#statement}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitBlockStatement(AngularParser.BlockStatementContext ctx);
	/**
	 * Visit a parse tree produced by the {@code functionCallStatement}
	 * labeled alternative in {@link AngularParser#statement}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitFunctionCallStatement(AngularParser.FunctionCallStatementContext ctx);
	/**
	 * Visit a parse tree produced by the {@code assignmentExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitAssignmentExpression(AngularParser.AssignmentExpressionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code identifierExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitIdentifierExpression(AngularParser.IdentifierExpressionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code functionCallExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitFunctionCallExpression(AngularParser.FunctionCallExpressionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code stringExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitStringExpression(AngularParser.StringExpressionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code numberExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitNumberExpression(AngularParser.NumberExpressionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code thisAssignmentExpression}
	 * labeled alternative in {@link AngularParser#expression}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitThisAssignmentExpression(AngularParser.ThisAssignmentExpressionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code functionCallDefinition}
	 * labeled alternative in {@link AngularParser#functionCall}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitFunctionCallDefinition(AngularParser.FunctionCallDefinitionContext ctx);
	/**
	 * Visit a parse tree produced by {@link AngularParser#argumentList}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitArgumentList(AngularParser.ArgumentListContext ctx);
	/**
	 * Visit a parse tree produced by the {@code testBlock}
	 * labeled alternative in {@link AngularParser#test}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitTestBlock(AngularParser.TestBlockContext ctx);
	/**
	 * Visit a parse tree produced by the {@code nullLiteral}
	 * labeled alternative in {@link AngularParser#literal}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitNullLiteral(AngularParser.NullLiteralContext ctx);
	/**
	 * Visit a parse tree produced by the {@code stringLiteral}
	 * labeled alternative in {@link AngularParser#literal}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitStringLiteral(AngularParser.StringLiteralContext ctx);
	/**
	 * Visit a parse tree produced by the {@code numberLiteral}
	 * labeled alternative in {@link AngularParser#literal}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitNumberLiteral(AngularParser.NumberLiteralContext ctx);
	/**
	 * Visit a parse tree produced by the {@code angularIdentifierExpression}
	 * labeled alternative in {@link AngularParser#angularExpression}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitAngularIdentifierExpression(AngularParser.AngularIdentifierExpressionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code angularStringExpression}
	 * labeled alternative in {@link AngularParser#angularExpression}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitAngularStringExpression(AngularParser.AngularStringExpressionContext ctx);
	/**
	 * Visit a parse tree produced by the {@code angularTemplateExpression}
	 * labeled alternative in {@link AngularParser#angularExpression}.
	 * @param ctx the parse tree
	 * @return the visitor result
	 */
	T visitAngularTemplateExpression(AngularParser.AngularTemplateExpressionContext ctx);
}