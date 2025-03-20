import "./App.css";
import NavBar from "./components/NavBar/NavBar.jsx";
import Banner from "./components/Banner/Banner.jsx";
import Us from "./components/Us/Us.jsx"; 
import { BrowserRouter} from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";

function App() {
  return (
    <BrowserRouter>
      <NavBar />
      <Banner />
      <Us />
    </BrowserRouter>
  );
}

export default App;
