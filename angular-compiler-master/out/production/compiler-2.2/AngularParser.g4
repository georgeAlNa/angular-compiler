parser grammar AngularParser;

options { tokenVocab=AngularLexer; }

// Application Root Node
application
    : importStatement+ component* EOF #applicationRoot
    ;

importStatement
    : IMPORT LCURLEBRACE IDENTIFIER RCURLEBRACE (FROM STRING)? SEMICOLON #importStatementDefinition
    ;
// Component Definition
component
    : COMPONENT LPAREN componentMetadata RPAREN typeScriptClass #componentDefinition
    ;

// Component Metadata\
componentMetadata
    : LCURLEBRACE (metadataEntry (COMMA metadataEntry)*)? RCURLEBRACE #componentMetadataDefinition
    ;

// Metadata Entry
metadataEntry
    : SELECTOR COLON attributeValue #metadataSelector
    | TEMPLATE COLON inlineTemplate #metadataTemplate
    | STYLES COLON LSQBRACKET stylesContent RSQBRACKET #metadataStyles
    ;

stylesContent
    : BACKTICK cssContent* BACKTICK #stylesContentBlock
    ;

cssContent
    : cssRule+ #cssContentRules
    ;

cssRule
    : (DOT? CSS_SELECTOR | CSS_SELECTOR) LCURLEBRACE cssDeclaration* RCURLEBRACE #cssRuleDefinition
    ;

cssDeclaration
    : (CSS_PROPERTY | IDENTIFIER) COLON cssValue SEMICOLON #cssDeclarationEntry
    ;

cssValue
    : PERCENTAGE #cssValuePercentage
    | FUNCTION_VALUE #cssValueFunction
    | COLOR #cssValueColor
    | STRING #cssValueString
    | NUMBER #cssValueNumber
    | ALPHABET_ONLY #cssValueAlphabet
    ;

// Inline Template
inlineTemplate
    : BACKTICK htmlDocument? BACKTICK #inlineTemplateDefinition
    ;

// HTML Document
htmlDocument
    : htmlElement* #htmlDocumentContent
    ;

// HTML Element
htmlElement
    : startTag htmlContent* endTag #htmlStandardElement
    | selfClosingTag #htmlSelfClosingElement
    ;

// HTML Start Tag
startTag
    : LT tagName attribute* GT #htmlStartTag
    ;

// HTML End Tag
endTag
    : CLOSE_TAG tagName GT #htmlEndTag
    ;

// HTML Self-Closing Tag
selfClosingTag
    : LT tagName attribute* SELF_CLOSE #htmlSelfClosingTag
    ;

// HTML Content
htmlContent
    : htmlElement #htmlNestedElement
    | TEXT #htmlTextContent
    | TEMPLATE_EXPRESSION #htmlTemplateExpression
    ;

// HTML Tag Name
tagName
    : IDENTIFIER #htmlTagName
    ;

// HTML Attribute
attribute
    : IDENTIFIER EQUAL attributeValue #htmlAttributeBasic
    | CLASS EQUAL attributeValue #htmlAttributeClass
    | STRUCTURAL_DIRECTIVE EQUAL attributeValue #htmlAttributeStructural
    | BINDING EQUAL attributeValue #htmlAttributeBinding
    | EVENT_BINDING EQUAL attributeValue #htmlAttributeEventBinding
    ;

// HTML Attribute Value
attributeValue
    : STRING #htmlAttributeValue
    ;

// TypeScript Class Definition
typeScriptClass
    : EXPORT CLASS IDENTIFIER LCURLEBRACE classBody RCURLEBRACE #typeScriptClassDefinition
    ;

// TypeScript Class Body
classBody
    : (classMember)* #classBodyContent
    ;

// TypeScript Class Member
classMember
    : propertyDeclaration #classProperty
    | methodDeclaration #classMethod
    ;

// Property Declaration
propertyDeclaration
    : IDENTIFIER EQUAL (literal | LSQBRACKET (test COMMA)* RSQBRACKET) SEMICOLON #propertyDeclarationStatement
    ;

// Method Declaration
methodDeclaration
    : IDENTIFIER LPAREN (parameterList)? RPAREN LCURLEBRACE methodBody RCURLEBRACE #methodDeclarationDefinition
    ;

// Parameter List for Methods
parameterList
    : IDENTIFIER (COMMA IDENTIFIER)* #methodParameterList
    ;

// Method Body
methodBody
    : (statement)* #methodBodyContent
    ;

statement
    : expression SEMICOLON #expressionStatement
    | LCURLEBRACE statement* RCURLEBRACE #blockStatement
    | functionCall SEMICOLON #functionCallStatement
    ;

expression
    : IDENTIFIER EQUAL expression #assignmentExpression
    | IDENTIFIER #identifierExpression
    | functionCall #functionCallExpression
    | STRING #stringExpression
    | NUMBER #numberExpression
    | THIS DOT IDENTIFIER EQUAL IDENTIFIER #thisAssignmentExpression
    ;

functionCall
    : functionName=IDENTIFIER LPAREN args=argumentList? RPAREN #functionCallDefinition
    ;

argumentList
    : expression (COMMA expression)*
    ;

test
    : LCURLEBRACE angularExpression* RCURLEBRACE #testBlock
    ;

literal
    : NULL #nullLiteral
    | STRING #stringLiteral
    | NUMBER #numberLiteral
    ;

// Angular Expression
angularExpression
    : IDENTIFIER COLON #angularIdentifierExpression
    | STRING COMMA #angularStringExpression
    | TEMPLATE_EXPRESSION #angularTemplateExpression
    ;



// دمج html parser مع ملفنا
//parser grammar AngularParser;
//
//options {
//    tokenVocab = AngularLexer;
//}
//
//// Application Root Node
//application
//    : importStatement+ component* EOF #applicationRoot
//    ;
//
//// Import Statement
//importStatement
//    : IMPORT LCURLEBRACE IDENTIFIER RCURLEBRACE (FROM STRING)? SEMICOLON #importStatementDefinition
//    ;
//
//// Component Definition
//component
//    : COMPONENT LPAREN componentMetadata RPAREN typeScriptClass #componentDefinition
//    ;
//
//// Component Metadata
//componentMetadata
//    : LCURLEBRACE (metadataEntry (COMMA metadataEntry)*)? RCURLEBRACE #componentMetadataDefinition
//    ;
//
//// Metadata Entry
//metadataEntry
//    : SELECTOR COLON attributeValue #metadataSelector
//    | TEMPLATE COLON inlineTemplate #metadataTemplate
//    | STYLES COLON LSQBRACKET stylesContent RSQBRACKET #metadataStyles
//    ;
//
//// Styles Content
//stylesContent
//    : BACKTICK cssContent* BACKTICK #stylesContentBlock
//    ;
//
//// CSS Content
//cssContent
//    : cssRule+ #cssContentRules
//    ;
//
//// CSS Rule
//cssRule
//    : (DOT? CSS_SELECTOR | CSS_SELECTOR) LCURLEBRACE cssDeclaration* RCURLEBRACE #cssRuleDefinition
//    ;
//
//// CSS Declaration
//cssDeclaration
//    : (CSS_PROPERTY | IDENTIFIER) COLON cssValue SEMICOLON #cssDeclarationEntry
//    ;
//
//// CSS Value
//cssValue
//    : PERCENTAGE #cssValuePercentage
//    | FUNCTION_VALUE #cssValueFunction
//    | COLOR #cssValueColor
//    | STRING #cssValueString
//    | NUMBER #cssValueNumber
//    | ALPHABET_ONLY #cssValueAlphabet
//    ;
//
//// Inline Template
//inlineTemplate
//    : BACKTICK htmlDocument? BACKTICK #inlineTemplateDefinition
//    ;
//
//// HTML Document
//htmlDocument
//    : htmlElement* #htmlDocumentContent
//    ;
//
//// HTML Element
//htmlElement
//    : startTag htmlContent* endTag #htmlStandardElement
//    | selfClosingTag #htmlSelfClosingElement
//    ;
//
//// HTML Start Tag
//startTag
//    : LT tagName attribute* GT #htmlStartTag
//    ;
//
//// HTML End Tag
//endTag
//    : CLOSE_TAG tagName GT #htmlEndTag
//    ;
//
//// HTML Self-Closing Tag
//selfClosingTag
//    : LT tagName attribute* SELF_CLOSE #htmlSelfClosingTag
//    ;
//
//// HTML Content
//htmlContent
//    : htmlElement #htmlNestedElement
//    | TEXT #htmlTextContent
//    | TEMPLATE_EXPRESSION #htmlTemplateExpression
//    ;
//
//// HTML Tag Name
//tagName
//    : IDENTIFIER #htmlTagName
//    ;
//
//// HTML Attribute
//attribute
//    : IDENTIFIER EQUAL attributeValue #htmlAttributeBasic
//    | CLASS EQUAL attributeValue #htmlAttributeClass
//    | STRUCTURAL_DIRECTIVE EQUAL attributeValue #htmlAttributeStructural
//    | BINDING EQUAL attributeValue #htmlAttributeBinding
//    | EVENT_BINDING EQUAL attributeValue #htmlAttributeEventBinding
//    ;
//
//// HTML Attribute Value
//attributeValue
//    : STRING #htmlAttributeValue
//    ;
//
//// TypeScript Class Definition
//typeScriptClass
//    : EXPORT CLASS IDENTIFIER LCURLEBRACE classBody RCURLEBRACE #typeScriptClassDefinition
//    ;
//
//// TypeScript Class Body
//classBody
//    : (classMember)* #classBodyContent
//    ;
//
//// TypeScript Class Member
//classMember
//    : propertyDeclaration #classProperty
//    | methodDeclaration #classMethod
//    ;
//
//// Property Declaration
//propertyDeclaration
//    : IDENTIFIER EQUAL (literal | LSQBRACKET (test COMMA)* RSQBRACKET) SEMICOLON #propertyDeclarationStatement
//    ;
//
//// Method Declaration
//methodDeclaration
//    : IDENTIFIER LPAREN (parameterList)? RPAREN LCURLEBRACE methodBody RCURLEBRACE #methodDeclarationDefinition
//    ;
//
//// Parameter List for Methods
//parameterList
//    : IDENTIFIER (COMMA IDENTIFIER)* #methodParameterList
//    ;
//
//// Method Body
//methodBody
//    : (statement)* #methodBodyContent
//    ;
//
//// Statement
//statement
//    : expression SEMICOLON #expressionStatement
//    | LCURLEBRACE statement* RCURLEBRACE #blockStatement
//    | functionCall SEMICOLON #functionCallStatement
//    ;
//
//// Expression
//expression
//    : IDENTIFIER EQUAL expression #assignmentExpression
//    | IDENTIFIER #identifierExpression
//    | functionCall #functionCallExpression
//    | STRING #stringExpression
//    | NUMBER #numberExpression
//    | THIS DOT IDENTIFIER EQUAL IDENTIFIER #thisAssignmentExpression
//    ;
//
//// Function Call
//functionCall
//    : functionName=IDENTIFIER LPAREN args=argumentList? RPAREN #functionCallDefinition
//    ;
//
//// Argument List for Functions
//argumentList
//    : expression (COMMA expression)*
//    ;
//
//// Test Block for Angular Expressions
//test
//    : LCURLEBRACE angularExpression* RCURLEBRACE #testBlock
//    ;
//
//// Literal Values
//literal
//    : NULL #nullLiteral
//    | STRING #stringLiteral
//    | NUMBER #numberLiteral
//    ;
//
//// Angular Expression
//angularExpression
//    : IDENTIFIER COLON #angularIdentifierExpression
//    | STRING COMMA #angularStringExpression
//    | TEMPLATE_EXPRESSION #angularTemplateExpression
//    ;
//
//
//// HTML Parsing Rules (from previous HTMLParser)
//
//htmlDocument
//    : scriptletOrSeaWs* XML? scriptletOrSeaWs* DTD? scriptletOrSeaWs* htmlElements*
//    ;
//
//scriptletOrSeaWs
//    : SCRIPTLET
//    | SEA_WS
//    ;
//
//htmlElements
//    : htmlMisc* htmlElement htmlMisc*
//    ;
//
//htmlElement
//    : TAG_OPEN TAG_NAME htmlAttribute* (
//        TAG_CLOSE (htmlContent TAG_OPEN TAG_SLASH TAG_NAME TAG_CLOSE)?
//        | TAG_SLASH_CLOSE
//    )
//    | SCRIPTLET
//    | script
//    | style
//    ;
//
//htmlContent
//    : htmlChardata? ((htmlElement | CDATA | htmlComment) htmlChardata?)*
//    ;
//
//htmlAttribute
//    : TAG_NAME (TAG_EQUALS ATTVALUE_VALUE)?
//    ;
//
//htmlChardata
//    : HTML_TEXT
//    | SEA_WS
//    ;
//
//htmlMisc
//    : htmlComment
//    | SEA_WS
//    ;
//
//htmlComment
//    : HTML_COMMENT
//    | HTML_CONDITIONAL_COMMENT
//    ;
//
//script
//    : SCRIPT_OPEN (SCRIPT_BODY | SCRIPT_SHORT_BODY)
//    ;
//
//style
//    : STYLE_OPEN (STYLE_BODY | STYLE_SHORT_BODY)
//    ;
