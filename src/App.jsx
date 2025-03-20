import "./App.css";
import NavBar from "./components/NavBar/NavBar.jsx";
import { BrowserRouter} from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";

function App() {
  return (
    <BrowserRouter>
      <NavBar />
    </BrowserRouter>
  );
}

export default App;
