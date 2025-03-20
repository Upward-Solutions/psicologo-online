import "./Banner.css"; 
import psicologiaOnlineImage from "../../assets/psicologia_online.jpg";

const Banner = () => {
  return (
    <div className="banner">
      <img src={psicologiaOnlineImage} alt="Banner" className="banner-image" />
    </div>
  );
};

export default Banner;