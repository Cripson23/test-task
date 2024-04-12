import { ThemeProvider } from 'styled-components';
import {theme} from "./styles/theme";
import GlobalStyle from "./styles/GlobalStyle";

import ProductList from "./components/ProductList/ProductList";

function App() {
  return (
    <ThemeProvider theme={theme}>
        <GlobalStyle />
        <ProductList />
    </ThemeProvider>
  );
}

export default App;
