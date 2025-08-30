lexer grammar AngularLexer;

IMPORT : 'import';
FROM : 'from';

// Angular-Specific Tokens
COMPONENT : '@Component';
SELECTOR : 'selector';
TEMPLATE : 'template';
STYLES : 'styles';
BACKTICK : '`';
TEMPLATE_EXPRESSION : '{{' .*? '}}';

// Structural Tokens
LCURLEBRACE : '{';
RCURLEBRACE : '}';
LSQBRACKET : '[';
RSQBRACKET : ']';
LPAREN : '(';
RPAREN : ')';
COLON : ':';
COMMA : ',';
DOT : '.';
SEMICOLON : ';';
STAR : '*';
SELF_CLOSE : '/>';
CLOSE_TAG : '</';
GT : '>';
LT : '<';
EQUAL : '=';
QUESTION_MARK : '?';

// Operators
PLUS : '+';
MINUS : '-';
SLASH : '/';
EQEQ : '==';
EQEQEQ : '===';
LESSOREQUAL : '<=';
GREATEROREQUAL : '>=';
NOTEQUAL : '!=';



// TypeScript Keywords
CLASS : 'class';
THIS: 'this';
CONST : 'const';
NULL : 'null';
LET : 'let';
VAR : 'var';
FUNCTION : 'function';
RETURN : 'return';
EXPORT : 'export';
IDENTIFIER : [a-zA-Z_][a-zA-Z0-9_]*;
EXTENDS : 'extends';
IMPLEMENTS : 'implements';


// General Tokens
STRING : '"' (~["\\\r\n])* '"' | '\'' (~['\\\r\n])* '\'';
BOOLEAN : 'true' | 'false';
NUMBER : [0-9]+ ('.' [0-9]+)?;
ALPHABET_ONLY : [a-zA-Z]* ;



//CSS_PROPERTY : [a-zA-Z\-]+ ;
//CSS_VALUE
//    : PERCENTAGE
//    | ALPHABET_ONLY
//    ;

PERCENTAGE : [0-9]+ '%';

FUNCTION_VALUE : [a-zA-Z\-]+ '(' .*? ')';
COLOR : '#' [0-9A-Fa-f] [0-9A-Fa-f] [0-9A-Fa-f] ([0-9A-Fa-f] [0-9A-Fa-f] [0-9A-Fa-f])? ;



// Angular-Specific Directives and Bindings
BINDING : LSQBRACKET IDENTIFIER RSQBRACKET;
EVENT_BINDING : LPAREN IDENTIFIER RPAREN;
STRUCTURAL_DIRECTIVE : STAR IDENTIFIER;

PROPERTY_BINDING : '[' IDENTIFIER ']' ;

// CSS Tokens
CSS_SELECTOR : [a-zA-Z0-9_#\-.]+ ;


// Whitespace and Comments
WS : [ \t\r\n]+ -> skip;
LINE_COMMENT : '//' ~[\r\n]* -> skip;
BLOCK_COMMENT : '/*' .*? '*/' -> skip;












// دمج htmllexer مع ملفنا
//lexer grammar AngularLexer;
//
//// HTML Comments
//HTML_COMMENT: '<!--' .*? '-->';
//
//// Conditional Comments
//HTML_CONDITIONAL_COMMENT: '<![' .*? ']>' ;
//
//// XML Declaration
//XML: '<?xml' .*? '>' ;
//
//// CDATA
//CDATA: '<![CDATA[' .*? ']]>' ;
//
//// DOCTYPE
//DTD: '<!' .*? '>' ;
//
//// Scriptlets
//SCRIPTLET: '<?' .*? '?>' | '<%' .*? '%>' ;
//
//// Whitespace (Spaces, Tabs, newlines)
//SEA_WS: (' ' | '\t' | '\r'? '\n')+ ;
//
//// Tag Opening
//SCRIPT_OPEN: '<script' .*? '>' -> pushMode(SCRIPT);
//STYLE_OPEN: '<style' .*? '>' -> pushMode(STYLE);
//TAG_OPEN: '<' -> pushMode(TAG);
//
//// Text between tags
//HTML_TEXT: ~('<' | '>' | '/'>)+;
//
//// Angular-Specific Tokens
//IMPORT : 'import';
//FROM : 'from';
//
//// Angular-Specific Directives and Bindings
//COMPONENT : '@Component';
//SELECTOR : 'selector';
//TEMPLATE : 'template';
//STYLES : 'styles';
//BACKTICK : '`';
//TEMPLATE_EXPRESSION : '{{' .*? '}}';
//
//// Structural Tokens
//LCURLEBRACE : '{';
//RCURLEBRACE : '}';
//LSQBRACKET : '[';
//RSQBRACKET : ']';
//LPAREN : '(';
//RPAREN : ')';
//COLON : ':';
//COMMA : ',';
//DOT : '.';
//SEMICOLON : ';';
//STAR : '*';
//SELF_CLOSE : '/>';
//CLOSE_TAG : '</';
//GT : '>';
//LT : '<';
//EQUAL : '=';
//QUESTION_MARK : '?';
//
//// Operators
//PLUS : '+';
//MINUS : '-';
//SLASH : '/';
//EQEQ : '==';
//EQEQEQ : '===';
//LESSOREQUAL : '<=';
//GREATEROREQUAL : '>=';
//NOTEQUAL : '!=';
//
//// TypeScript Keywords
//CLASS : 'class';
//THIS: 'this';
//CONST : 'const';
//NULL : 'null';
//LET : 'let';
//VAR : 'var';
//FUNCTION : 'function';
//RETURN : 'return';
//EXPORT : 'export';
//IDENTIFIER : [a-zA-Z_][a-zA-Z0-9_]*;
//EXTENDS : 'extends';
//IMPLEMENTS : 'implements';
//
//// General Tokens
//STRING : '"' (~["\\\r\n])* '"' | '\'' (~['\\\r\n])* '\'';
//BOOLEAN : 'true' | 'false';
//NUMBER : [0-9]+ ('.' [0-9]+)?;
//ALPHABET_ONLY : [a-zA-Z]*;
//
//// CSS Tokens
//CSS_SELECTOR : [a-zA-Z0-9_#\-.]+ ;
//
//// CSS Property Percentage
//PERCENTAGE : [0-9]+ '%';
//
//// CSS Function Value
//FUNCTION_VALUE : [a-zA-Z\-]+ '(' .*? ')';
//
//// CSS Color Value
//COLOR : '#' [0-9A-Fa-f] [0-9A-Fa-f] [0-9A-Fa-f] ([0-9A-Fa-f] [0-9A-Fa-f] [0-9A-Fa-f])? ;
//
//// Angular-Specific Directives and Bindings
//BINDING : LSQBRACKET IDENTIFIER RSQBRACKET;
//EVENT_BINDING : LPAREN IDENTIFIER RPAREN;
//STRUCTURAL_DIRECTIVE : STAR IDENTIFIER;
//
//PROPERTY_BINDING : '[' IDENTIFIER ']' ;
//
//// Whitespace and Comments
//WS : [ \t\r\n]+ -> skip;
//LINE_COMMENT : '//' ~[\r\n]* -> skip;
//BLOCK_COMMENT : '/*' .*? '*/' -> skip;
//
//// Tag Declarations (HTML)
//mode TAG;
//
//// Tag Close
//TAG_CLOSE: '>' -> popMode;
//TAG_SLASH_CLOSE: '/>' -> popMode;
//TAG_SLASH: '/';
//
//// Lexing Mode for Attribute Values
//TAG_EQUALS: '=' -> pushMode(ATTVALUE);
//
//// Tag Name
//TAG_NAME: TAG_NameStartChar TAG_NameChar*;
//
//// Hidden whitespace in tags
//TAG_WHITESPACE: [ \t\r\n] -> channel(HIDDEN);
//
//// Hex and Digit fragments for tag names
//fragment HEXDIGIT: [a-fA-F0-9];
//fragment DIGIT: [0-9];
//
//// Tag Name Characters
//fragment TAG_NameChar:
//    TAG_NameStartChar
//    | '-'
//    | '_'
//    | '.'
//    | DIGIT
//    | '\u00B7'
//    | '\u0300' ..'\u036F'
//    | '\u203F' ..'\u2040'
//;
//
//// Tag Name Start Characters
//fragment TAG_NameStartChar:
//    [a-zA-Z]
//    | '\u2070' ..'\u218F'
//    | '\u2C00' ..'\u2FEF'
//    | '\u3001' ..'\uD7FF'
//    | '\uF900' ..'\uFDCF'
//    | '\uFDF0' ..'\uFFFD'
//;
//
//// Script Mode
//mode SCRIPT;
//SCRIPT_BODY: .*? '</script>' -> popMode;
//SCRIPT_SHORT_BODY: .*? '</>' -> popMode;
//
//// Style Mode
//mode STYLE;
//STYLE_BODY: .*? '</style>' -> popMode;
//STYLE_SHORT_BODY: .*? '</>' -> popMode;
//
//// Attribute Value Mode
//mode ATTVALUE;
//
//// Attribute Value
//ATTVALUE_VALUE: ' '* ATTRIBUTE -> popMode;
//
//// Attribute Definitions
//ATTRIBUTE: DOUBLE_QUOTE_STRING | SINGLE_QUOTE_STRING | ATTCHARS | HEXCHARS | DECCHARS;
//
//// Attribute Characters
//fragment ATTCHARS: ATTCHAR+ ' '?
//fragment ATTCHAR: '-' | '_' | '.' | '/' | '+' | ',' | '?' | '=' | ':' | ';' | '#' | [0-9a-zA-Z];
//
//// Hexadecimal Values
//fragment HEXCHARS: '#' [0-9a-fA-F]+;
//
//// Decimal Values
//fragment DECCHARS: [0-9]+ '%'?;
//
//// Double Quote String for Attributes
//fragment DOUBLE_QUOTE_STRING: '"' ~[<"]* '"';
//
//// Single Quote String for Attributes
//fragment SINGLE_QUOTE_STRING: '\'' ~[<']* '\'';












//!  دمج قواعد الhtml مع الlexer لاساسي//////////////////////
// lexer grammar AngularLexer;
//
//// HTML Comments
//HTML_COMMENT: '<!--' .*? '-->';
//
//// Conditional Comments
//HTML_CONDITIONAL_COMMENT: '<!\[' .*? '\]>' ;
//
//// XML Declaration
//XML: '<?xml' .*? '>' ;
//
//// CDATA
//CDATA: '<!\[CDATA\[' .*? '\]\]>' ;
//
//// DOCTYPE
//DTD: '<!' .*? '>' ;
//
//// Scriptlets
//SCRIPTLET: '<?' .*? '?>' | '<%' .*? '%>' ;
//
//// Whitespace (Spaces, Tabs, newlines)
//SEA_WS: (' ' | '\t' | '\r'? '\n')+ ;
//
//// Tag Opening
//SCRIPT_OPEN: '<script' .*? '>' -> pushMode(SCRIPT);
//STYLE_OPEN: '<style' .*? '>' -> pushMode(STYLE);
//TAG_OPEN: '<' -> pushMode(TAG);
//
//// Text between tags
//HTML_TEXT: ~('<' | '>' | '/')+;
//
//// Angular-Specific Tokens
//IMPORT : 'import';
//FROM : 'from';
//
//// Angular-Specific Directives and Bindings
//COMPONENT : '@Component';
//SELECTOR : 'selector';
//TEMPLATE : 'template';
//STYLES : 'styles';
//BACKTICK : '`';
//TEMPLATE_EXPRESSION : '{{' .*? '}}';
//
//// Structural Tokens
//LCURLEBRACE : '{';
//RCURLEBRACE : '}';
//LSQBRACKET : '[';
//RSQBRACKET : ']';
//LPAREN : '(';
//RPAREN : ')';
//COLON : ':';
//COMMA : ',';
//DOT : '.';
//SEMICOLON : ';';
//STAR : '*';
//SELF_CLOSE : '/>';
//CLOSE_TAG : '</';
//GT : '>';
//LT : '<';
//EQUAL : '=';
//QUESTION_MARK : '?';
//
//// Operators
//PLUS : '+';
//MINUS : '-';
//SLASH : '/';
//EQEQ : '==';
//EQEQEQ : '===';
//LESSOREQUAL : '<=';
//GREATEROREQUAL : '>=';
//NOTEQUAL : '!=';
//
//// TypeScript Keywords
//CLASS : 'class';
//THIS: 'this';
//CONST : 'const';
//NULL : 'null';
//LET : 'let';
//VAR : 'var';
//FUNCTION : 'function';
//RETURN : 'return';
//EXPORT : 'export';
//IDENTIFIER : [a-zA-Z_][a-zA-Z0-9_]*;
//EXTENDS : 'extends';
//IMPLEMENTS : 'implements';
//
//// General Tokens
//STRING : '"' (~["\\\r\n])* '"' | '\'' (~['\\\r\n])* '\'';
//BOOLEAN : 'true' | 'false';
//NUMBER : [0-9]+ ('.' [0-9]+)?;
//ALPHABET_ONLY : [a-zA-Z]*;
//
//// CSS Tokens
//CSS_SELECTOR : [a-zA-Z0-9_#\-.]+ ;
//
//// CSS Property Percentage
//PERCENTAGE : [0-9]+ '%';
//
//// CSS Function Value
//FUNCTION_VALUE : [a-zA-Z\-]+ '(' .*? ')';
//
//// CSS Color Value
//COLOR : '#' [0-9A-Fa-f] [0-9A-Fa-f] [0-9A-Fa-f] ([0-9A-Fa-f] [0-9A-Fa-f] [0-9A-Fa-f])? ;
//
//// Angular-Specific Directives and Bindings
//BINDING : LSQBRACKET IDENTIFIER RSQBRACKET;
//EVENT_BINDING : LPAREN IDENTIFIER RPAREN;
//STRUCTURAL_DIRECTIVE : STAR IDENTIFIER;
//PROPERTY_BINDING : '[' IDENTIFIER ']' ;
//
//// Whitespace and Comments
//WS : [ \t\r\n]+ -> skip;
//LINE_COMMENT : '//' ~[\r\n]* -> skip;
//BLOCK_COMMENT : '/*' .*? '*/' -> skip;
//
//// Tag Declarations (HTML)
//mode TAG;
//
//// Tag Close
//TAG_CLOSE: '>' -> popMode;
//TAG_SLASH_CLOSE: '/>' -> popMode;
//TAG_SLASH: '/';
//
//// Lexing Mode for Attribute Values
//TAG_EQUALS: '=' -> pushMode(ATTVALUE);
//
//// Tag Name
//TAG_NAME: TAG_NameStartChar TAG_NameChar*;
//
//// Hidden whitespace in tags
//TAG_WHITESPACE: [ \t\r\n] -> channel(HIDDEN);
//
//// Hex and Digit fragments for tag names
//fragment HEXDIGIT: [a-fA-F0-9];
//fragment DIGIT: [0-9];
//
//// Tag Name Characters
//fragment TAG_NameChar:
//    TAG_NameStartChar
//    | '-'
//    | '_'
//    | '.'
//    | DIGIT
//    | '\u00B7'
//    | '\u0300' ..'\u036F'
//    | '\u203F' ..'\u2040'
//;
//
//// Tag Name Start Characters
//fragment TAG_NameStartChar:
//    [a-zA-Z]
//    | '\u2070' ..'\u218F'
//    | '\u2C00' ..'\u2FEF'
//    | '\u3001' ..'\uD7FF'
//    | '\uF900' ..'\uFDCF'
//    | '\uFDF0' ..'\uFFFD'
//;
//
//// Script Mode
//mode SCRIPT;
//SCRIPT_BODY: .*? '</script>' -> popMode;
//SCRIPT_SHORT_BODY: .*? '</>' -> popMode;
//
//// Style Mode
//mode STYLE;
//STYLE_BODY: .*? '</style>' -> popMode;
//STYLE_SHORT_BODY: .*? '</>' -> popMode;
//
//// Attribute Value Mode
//mode ATTVALUE;
//
//// Attribute Value
//ATTVALUE_VALUE: ' '* ATTRIBUTE -> popMode;
//
//// Attribute Definitions
//ATTRIBUTE: DOUBLE_QUOTE_STRING | SINGLE_QUOTE_STRING | ATTCHARS | HEXCHARS | DECCHARS;
//
//// Attribute Characters
//fragment ATTCHARS: ATTCHAR+ ' '?;
//fragment ATTCHAR: '-' | '_' | '.' | '/' | '+' | ',' | '?' | '=' | ':' | ';' | '#' | [0-9a-zA-Z];
//
//// Hexadecimal Values
//fragment HEXCHARS: '#' [0-9a-fA-F]+;
//
//// Decimal Values
//fragment DECCHARS: [0-9]+ '%'?;
//
//// Double Quote String for Attributes
//fragment DOUBLE_QUOTE_STRING: '"' ~[<"]* '"';
//
//// Single Quote String for Attributes
//fragment SINGLE_QUOTE_STRING: '\'' ~[<']* '\'';








//lexer grammar AngularLexer;
//
//// كلمات محجوزة أولاً
//IMPORT : 'import';
//FROM : 'from';
//
//// Angular-Specific Tokens
//COMPONENT : '@Component';
//SELECTOR : 'selector';
//TEMPLATE : 'template';
//STYLES : 'styles';
//BACKTICK : '`';
//TEMPLATE_EXPRESSION : '{{' .*? '}}';
//
//// Structural Tokens
//LCURLEBRACE : '{';
//RCURLEBRACE : '}';
//LSQBRACKET : '[';
//RSQBRACKET : ']';
//LPAREN : '(';
//RPAREN : ')';
//COLON : ':';
//COMMA : ',';
//DOT : '.';
//SEMICOLON : ';';
//STAR : '*';
//SELF_CLOSE : '/>';
//CLOSE_TAG : '</';
//GT : '>';
//LT : '<';
//EQUAL : '=';
//QUESTION_MARK : '?';
//
//// Operators
//PLUS : '+';
//MINUS : '-';
//SLASH : '/';
//EQEQ : '==';
//EQEQEQ : '===';
//LESSOREQUAL : '<=';
//GREATEROREQUAL : '>=';
//NOTEQUAL : '!=';
//
//// TypeScript Keywords
//CLASS : 'class';
//THIS: 'this';
//CONST : 'const';
//NULL : 'null';
//LET : 'let';
//VAR : 'var';
//FUNCTION : 'function';
//RETURN : 'return';
//EXPORT : 'export';
//IDENTIFIER : [a-zA-Z_][a-zA-Z0-9_]*;
//EXTENDS : 'extends';
//IMPLEMENTS : 'implements';
//
//// General Tokens
//STRING : '"' (~["\\\r\n])* '"' | '\'' (~['\\\r\n])* '\'';
//BOOLEAN : 'true' | 'false';
//NUMBER : [0-9]+ ('.' [0-9]+)?;
//ALPHABET_ONLY : [a-zA-Z]*;
//
//// CSS Tokens
//CSS_SELECTOR : [a-zA-Z0-9_#\-.]+ ;
//
//// Whitespace and Comments
//WS : [ \t\r\n]+ -> skip;
//LINE_COMMENT : '//' ~[\r\n]* -> skip;
//BLOCK_COMMENT : '/*' .*? '*/' -> skip;
