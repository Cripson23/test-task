import { ThemeProvider } from 'styled-components';
import { Provider } from "react-redux";
import { theme } from "./styles/theme";
import store  from "./store";
import GlobalStyle from "./styles/GlobalStyle";

import ProductList from "./components/ProductList/ProductList";

function App() {
  return (
    <Provider store={store}>
        <ThemeProvider theme={theme}>
            <GlobalStyle />
            <ProductList />
        </ThemeProvider>
    </Provider>
  );
}

export default App;
