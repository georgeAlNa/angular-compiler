package semantic_check;

import symbol_table.SymbolTable;

import java.util.List;

public interface SemanticCheck {
    void check(SymbolTable symbolTable, List<SemanticError> errors);
}
