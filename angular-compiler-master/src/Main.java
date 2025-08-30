//
//import AngularGen.AngularLexer;
//import AngularGen.AngularParser;
//import classes.Application;
//import classes.BaseVisitor;
//import classes.Component;
//import code_generation.BaseComponentView;
//import code_generation.GeneratedComponent;
//import code_generation.View;
//import code_generation.ViewFactory;
//import org.antlr.v4.runtime.*; // تأكد من هذا الاستيراد
//import org.antlr.v4.runtime.tree.ParseTree;
//
//import java.io.IOException;
//import java.util.List;
//
//public class Main {
//    public static void main(String[] args) throws IOException {
////        String source = "test code.txt";
////        CharStream charStream = CharStreams.fromFileName(source);
////        AngularLexer lexer = new AngularLexer(charStream);
////        CommonTokenStream tokenStream = new CommonTokenStream(lexer);
////        AngularParser parser = new AngularParser(tokenStream);
////
////        ParseTree ast = parser.application();
////        BaseVisitor visitor = new BaseVisitor();
////        Application program = (Application) visitor.visit(ast);
////
////        System.out.println(program);
//
//
//        String source = "test code.txt";
//
////        String source = "test1(selector,template).txt";
////        String source = "test2(ngfor).txt";
////        String source = "test3(variable).txt";
////        String source = "test4(method).txt";
////        String source = "test5(ngIf).txt";
//
//
//        CharStream charStream = CharStreams.fromFileName(source);
//        AngularLexer lexer = new AngularLexer(charStream);
//        CommonTokenStream tokenStream = new CommonTokenStream(lexer);
//        AngularParser parser = new AngularParser(tokenStream);
//
//        ParseTree ast = parser.application();
//        BaseVisitor visitor = new BaseVisitor();
//        Application program = (Application) visitor.visit(ast);
//
//        List<Component> components = program.getComponents();
//        for (Component component : components) {
//            BaseComponentView view = ViewFactory.createView(component);
//            GeneratedComponent generated = view.generate();
//
//            System.out.println("=== " + view.getClass().getSimpleName() + " ===");
//            System.out.println("TS:\n" + generated.getTs());
//            System.out.println("HTML:\n" + generated.getHtml());
//            System.out.println("CSS:\n" + generated.getCss());
//            System.out.println("\n" + "-".repeat(50) + "\n");
//        }
//
//        System.out.println(program);
//
//    }
//}


import AngularGen.AngularLexer;
import AngularGen.AngularParser;
import classes.Application;
import classes.BaseVisitor;
import classes.Component;
import code_generation.BaseComponentView;
import code_generation.GeneratedComponent;
import code_generation.ComponentFileSaver;
import code_generation.ViewFactory;
import org.antlr.v4.runtime.*;
import org.antlr.v4.runtime.tree.ParseTree;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class Main {
    public static void main(String[] args) throws IOException {
        String source = "test code.txt";
        final String OUTPUT_DIR = "generated_components"; // مجلد لحفظ الملفات

        CharStream charStream = CharStreams.fromFileName(source);
        AngularLexer lexer = new AngularLexer(charStream);
        CommonTokenStream tokenStream = new CommonTokenStream(lexer);
        AngularParser parser = new AngularParser(tokenStream);

        ParseTree ast = parser.application();
        BaseVisitor visitor = new BaseVisitor();
        Application program = (Application) visitor.visit(ast);

        List<Component> components = program.getComponents();
        List<GeneratedComponent> generatedComponents = new ArrayList<>();

        // توليد جميع المكونات
        for (Component component : components) {
            BaseComponentView view = ViewFactory.createView(component);
            GeneratedComponent generated = view.generate();
            generatedComponents.add(generated);

            // طباعة المعلومات للتحقق
            System.out.println("=== " + view.getClass().getSimpleName() + " ===");
            System.out.println("TS:\n" + generated.getTs());
            System.out.println("HTML:\n" + generated.getHtml());
            System.out.println("CSS:\n" + generated.getCss());
            System.out.println("\n" + "-".repeat(50) + "\n");
        }

        // حفظ جميع المكونات في ملفات
        ComponentFileSaver.saveComponents(generatedComponents, OUTPUT_DIR);

        System.out.println(program);
    }
}