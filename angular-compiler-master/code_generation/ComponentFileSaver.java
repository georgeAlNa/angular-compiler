package code_generation;

import java.io.FileWriter;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.List;

public class ComponentFileSaver {

    public static void saveComponents(List<GeneratedComponent> components, String outputDir) {
        try {
            Files.createDirectories(Paths.get(outputDir));

            for (GeneratedComponent component : components) {
                String componentName = component.getComponentName();

                if (component.getTs() != null && !component.getTs().trim().isEmpty()) {
                    saveToFile(outputDir + "/" + componentName + ".ts", component.getTs());
                }

                if (component.getHtml() != null && !component.getHtml().trim().isEmpty()) {
                    saveToFile(outputDir + "/" + componentName + ".html", component.getHtml());
                }

                if (component.getCss() != null && !component.getCss().trim().isEmpty()) {
                    saveToFile(outputDir + "/" + componentName + ".css", component.getCss());
                }
            }

            System.out.println("تم حفظ " + components.size() + " مكونات في: " + outputDir);

        } catch (IOException e) {
            System.err.println("خطأ في إنشاء المجلد: " + e.getMessage());
        }
    }
    private static void saveToFile(String filePath, String content) {
        try (FileWriter writer = new FileWriter(filePath, true)) {
            writer.write(content);
            writer.write("\n/* ============================= */\n\n");
            System.out.println("تم حفظ الملف: " + filePath);
        } catch (IOException e) {
            System.err.println("خطأ في حفظ الملف " + filePath + ": " + e.getMessage());
        }
    }

//    private static void saveToFile(String filePath, String content) {
//        try (FileWriter writer = new FileWriter(filePath, true)) { // <-- Append mode
//            writer.write("/* ============================= */\n");
//            writer.write(content);
//            writer.write("/* ============================= */\n");
//            writer.write(System.lineSeparator()); // يفصل بين كل component واللي بعده
//            System.out.println("تم حفظ الملف: " + filePath);
//        } catch (IOException e) {
//            System.err.println("خطأ في حفظ الملف " + filePath + ": " + e.getMessage());
//        }
//    }

}