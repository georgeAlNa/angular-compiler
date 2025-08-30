package classes;

import java.util.ArrayList;
import java.util.List;

public class Application extends ComponentNode{
    private List<Component> components = new ArrayList<>();

        public List<Component> getComponents() {
            return components;
        }

        public void setComponents(List<Component> components) {
            this.components = components;
        }

        @Override
        public String toString() {
            StringBuilder sb = new StringBuilder("\nApplication{");
            if (components != null) {
                for (Component component : components) {
                    sb.append("\n").append(component);
                }
            }
            sb.append("\n}");
            return sb.toString();
        }
    }

