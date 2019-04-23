<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sensors;
use AppBundle\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Psr\Log\LoggerInterface;


class BaseController extends Controller {

  /**
   * @Route( "/", name = "base" )
   */
  
  public function baseAction()
  {
    return $this->render('temp/main.html.twig', array(
    ));
  }

  /**
   * @Route( "/login", name = "login" )
   */
  
  public function loginAction()
  {
    return $this->render('temp/login.html.twig', array(
    ));
  }

  /**
   * @Route( "/sign", name = "sign" )
   */
  
  public function signAction()
  {
    return $this->render('temp/registration.html.twig', array(
    ));
  }

  /**
   * @Route( "/enter", name = "enter" )
   */
  
  public function enterAction(Request $request)
  {
    $username = $request->query->get('username');
    $password = $request->query->get('pass');

    $lamp = $this->getDoctrine()->getRepository(Sensors::class)->findOneById(2);
    $user = $this->getDoctrine()->getRepository(Users::class)->findOneByEmail($username);

    $entityManager = $this->getDoctrine()->getManager();


    if ( $user->getEmail() == $username && $user->getPassword() == $password ) {
      $lamp->setLamp1($user->getId());
      $entityManager->persist($lamp);
      $entityManager->flush();
      return $this->redirectToRoute('adminka');
    } else {
      return $this->redirectToRoute('login');
    }
  }

  /**
   * @Route( "/create", name = "create" )
   */
  
  public function createAction(Request $request)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $user = new Users();

    $user->setEmail($request->query->get('username'));
    $user->setPassword($request->query->get('pass'));

    $entityManager->persist($user);
    $entityManager->flush();

    $user = $this->getDoctrine()->getRepository(Users::class)->findOneByEmail($request->query->get('username'));
    $repository = $this->getDoctrine()->getRepository(Sensors::class);
    $lamp = $repository->find(2);
    $lamp->setLamp1($user->getId());

    $entityManager->persist($lamp);
    $entityManager->flush();

    return $this->redirectToRoute('adminka');
  }

  /**
   * @Route( "/getData", name = "getData" )
   */

  public function getDataAction(Request $request, \Swift_Mailer $mailer, LoggerInterface $logger)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $sensors = new Sensors();

    $lamp1 = $this->getDoctrine()->getRepository(Sensors::class)->find(2);
    $user = $this->getDoctrine()->getRepository(Users::class)->findOneById($lamp1->getLamp1());

    $sensors->setPhotoresistor($request->query->get('photoresistor'));
    $sensors->setTemperature($request->query->get('temperature'));
    $sensors->setHumidity($request->query->get('humidity'));
    $sensors->setMotion($request->query->get('motion'));
    $sensors->setGas($request->query->get('gas'));
    
    $entityManager->persist($sensors);
    $entityManager->flush();

    if ($sensors->getGas() > 500) {
      $message = new \Swift_Message('Warning Message from Smart-Home');
      $message->setFrom('smarthome.smartteam@gmail.com');
      $message->setTo($user->getEmail());
      $message->setBody(
          $this->renderView(
              'temp/myemail.html.twig'
          ),
          'text/html'
      );

      $mailer->send($message);

      $logger->info('email sent');
      $this->addFlash('notice', 'Email sent');
    }

    return new Response(
      '<html><body>Success</body></html>'
    );
  }

  /**
   * @Route( "/getUpdate", name = "getUpdate")
   */

  public function getUpdate()
  {
    $update = $this->getDoctrine()->getRepository(Sensors::class)->findOneById(1);
    $response = "";
    if ($update->getSocket1()) {
      $response += "socket1On "; 
    } else {
      $response += "socket1Off ";
    }
    if ($update->getSocket2()) {
      $response += "socket2On ";
    } else {
      $response += "socket2Off ";
    }
    if ($update->getLamp1()) {
      $response += "lamp1On ";
    } else {
      $response += "lamp1Off ";
    }
    if ($update->getLamp2()) {
      $response += "lamp2On ";
    } else {
      $response += "lamp2Off ";
    }
    return new Response(
      $response
    );
  }

  /**
   *  @Route( "/adminka", name = "adminka" )
   */

  public function adminkaAction()
  {
    $sort = $this->getDoctrine()->getRepository(Sensors::class)->findOneBy([], ['id' => 'desc']);
    $lastId = $sort->getId();

    $motion = $this->getDoctrine()->getRepository(Sensors::class)->find($lastId);

    if (!$motion) {
      throw $this->createNotFoundException(
        'Данные отсутствуют!!!'
      );
    }
    return $this->render('temp/index.html.twig', array(
      'motion' => $motion,
    ));
  }

  /**
   * @Route( "/lamp", name = "lamp")
   */

  public function lampAction() {
    $sort = $this->getDoctrine()->getRepository(Sensors::class)->findOneBy([], ['id' => 'desc']);
    $lastId = $sort->getId();

    $photoresistor = $this->getDoctrine()->getRepository(Sensors::class)->find($lastId);
    $lamp1 = $this->getDoctrine()->getRepository(Sensors::class)->find(1);

    if (!$lamp1) {
      throw $this->createNotFoundException(
        'Данные отсутствуют!!!'
      );
    }

    return $this->render('temp/lamp.html.twig', array(
      'photoresistor' => $photoresistor,
      'lamp1' => $lamp1,
    ));
  }

  /**
   * @Route( "/lamp/power1", name = "lamp/power1")
   */

  public function lampPower1Action() {
    $repository = $this->getDoctrine()->getRepository(Sensors::class);
    $entityManager = $this->getDoctrine()->getManager();

    $lamp = $repository->find(1);

    if (!$lamp) {
      throw $this->createNotFoundException(
        'No product found for id '
      );
    }

    if ($lamp->getLamp1()) {
      $lamp->setLamp1(0);
    } else {
      $lamp->setLamp1(1);
    }

    $entityManager->persist($lamp);
    $entityManager->flush();

    return $this->redirectToRoute('lamp');
  }

  /**
   * @Route( "/lamp/power2", name = "lamp/power2")
   */

  public function lampPower2Action() {
    $repository = $this->getDoctrine()->getRepository(Sensors::class);
    $entityManager = $this->getDoctrine()->getManager();

    $lamp = $repository->find(1);

    if (!$lamp) {
      throw $this->createNotFoundException(
        'Данные отсутствуют!!!'
      );
    }

    if ($lamp->getLamp2()) {
      $lamp->setLamp2(0);
    } else {
      $lamp->setLamp2(1);
    }

    $entityManager->persist($lamp);
    $entityManager->flush();

    return $this->redirectToRoute('lamp');
  }

  /**
   * @Route( "/socket", name = "socket")
   */

  public function socketAction() {
    $socket = $this->getDoctrine()->getRepository(Sensors::class)->find(1);

    if (!$socket) {
      throw $this->createNotFoundException(
        'Данные отсутствуют!!!'
      );
    }

    return $this->render('temp/socket.html.twig', array(
      'socket' => $socket,
    ));
  }

  /**
   * @Route( "/socket/power1", name = "socket/power1")
   */

  public function socketPower1Action() {
    $repository = $this->getDoctrine()->getRepository(Sensors::class);
    $entityManager = $this->getDoctrine()->getManager();

    $socket = $repository->find(1);

    if (!$socket) {
      throw $this->createNotFoundException(
        'Данные отсутствуют!!!'
      );
    }

    if ($socket->getSocket1()) {
      $socket->setSocket1(0);
    } else {
      $socket->setSocket1(1);
    }

    $entityManager->persist($socket);
    $entityManager->flush();

    return $this->redirectToRoute('socket');
  }

  /**
   * @Route( "/socket/power2", name = "socket/power2")
   */

  public function socketPower2Action() {
    $repository = $this->getDoctrine()->getRepository(Sensors::class);
    $entityManager = $this->getDoctrine()->getManager();

    $socket = $repository->find(1);

    if (!$socket) {
      throw $this->createNotFoundException(
        'Данные отсутствуют!!!'
      );
    }

    if ($socket->getSocket2()) {
      $socket->setSocket2(0);
    } else {
      $socket->setSocket2(1);
    }

    $entityManager->persist($socket);
    $entityManager->flush();

    return $this->redirectToRoute('socket');
  }

  /**
   * @Route( "/humadity", name = "humadity")
   */

  public function humadityAction() {
    $sort = $this->getDoctrine()->getRepository(Sensors::class)->findOneBy([], ['id' => 'desc']);
    $lastId = $sort->getId();
    $humidity = $this->getDoctrine()->getRepository(Sensors::class)->find($lastId);

    if (!$humidity) {
      throw $this->createNotFoundException(
        'Данные отсутствуют!!!'
      );
    }

    return $this->render('temp/humidity.html.twig', array(
      'humidity' => $humidity,
    ));
  }

  /**
   * @Route( "/temperatura", name = "temperatura")
   */

  public function temperaturaAction() {
    $sort = $this->getDoctrine()->getRepository(Sensors::class)->findOneBy([], ['id' => 'desc']);
    $lastId = $sort->getId();

    $temperature = $this->getDoctrine()->getRepository(Sensors::class)->find($lastId);

    if (!$temperature) {
      throw $this->createNotFoundException(
        'Данные отсутствуют!!!'
      );
    }

    return $this->render('temp/temperature.html.twig', array(
      'temperature' => $temperature,
    ));
  }
}